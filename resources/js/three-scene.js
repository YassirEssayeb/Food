import * as THREE from 'three';
import { RoomEnvironment } from 'three/addons/environments/RoomEnvironment.js';
import { EffectComposer } from 'three/addons/postprocessing/EffectComposer.js';
import { RenderPass } from 'three/addons/postprocessing/RenderPass.js';
import { UnrealBloomPass } from 'three/addons/postprocessing/UnrealBloomPass.js';
import { BokehPass } from 'three/addons/postprocessing/BokehPass.js';
import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';
import { DRACOLoader } from 'three/addons/loaders/DRACOLoader.js';

class Burger3DScene {
    constructor() {
        this.container = document.getElementById('three-canvas');
        if (!this.container) return;

        this.mouse = new THREE.Vector2(0, 0);
        this.targetRotation = new THREE.Vector2(0, 0);
        this.scrollY = 0;
        this.clock = new THREE.Clock();
        this.burgerGroup = null;
        this.floatingIngredients = [];
        this.particles = null;
        this.smokeParticles = null;
        this.smokeVelocities = [];
        this.smokeLifetimes = [];
        this.isMobile = window.innerWidth < 768;
        this.isTablet = window.innerWidth < 1024;
        this.glowLights = [];
        this.composer = null;
        this.modelLoaded = false;

        this.initScene();
        this.loadBurgerGLB();
        this.createLighting();
        this.createFloatingIngredients();
        this.createParticleSystem();
        this.createSmokeSystem();
        this.createGroundPlane();
        this.createOrangeGlow();
        this.bindEvents();
        this.animate();
    }

    initScene() {
        this.scene = new THREE.Scene();
        this.scene.background = null;

        const width = this.container.clientWidth;
        const height = this.container.clientHeight;

        this.camera = new THREE.PerspectiveCamera(35, width / height, 0.1, 100);
        this.camera.position.set(0, 0.9, 7.2);
        this.camera.lookAt(0, 0.05, 0);

        this.renderer = new THREE.WebGLRenderer({
            alpha: true,
            antialias: true,
            powerPreference: 'high-performance',
        });
        this.renderer.setSize(width, height);
        this.renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        this.renderer.shadowMap.enabled = true;
        this.renderer.shadowMap.type = THREE.PCFSoftShadowMap;
        this.renderer.toneMapping = THREE.ACESFilmicToneMapping;
        this.renderer.toneMappingExposure = 0.85;
        this.renderer.outputColorSpace = THREE.SRGBColorSpace;
        this.container.appendChild(this.renderer.domElement);

        const pmremGenerator = new THREE.PMREMGenerator(this.renderer);
        const envTexture = pmremGenerator.fromScene(new RoomEnvironment(this.renderer), 0.04).texture;
        this.scene.environment = envTexture;
        pmremGenerator.dispose();

        this.composer = new EffectComposer(this.renderer);
        const renderPass = new RenderPass(this.scene, this.camera);
        this.composer.addPass(renderPass);

        const bokehPass = new BokehPass(this.scene, this.camera, {
            focus: 7.0,
            aperture: 0.025,
            maxblur: 0.008,
        });
        this.composer.addPass(bokehPass);

        const bloomPass = new UnrealBloomPass(
            new THREE.Vector2(width, height),
            0.15,
            0.10,
            0.05
        );
        this.composer.addPass(bloomPass);
    }

    loadBurgerGLB() {
        this.burgerGroup = new THREE.Group();

        const loader = new GLTFLoader();
        const dracoLoader = new DRACOLoader();
        dracoLoader.setDecoderPath('https://www.gstatic.com/draco/versioned/decoders/1.5.6/');
        loader.setDRACOLoader(dracoLoader);

        loader.load(
            '/models/burger.glb',
            (gltf) => {
                const model = gltf.scene;

                const box = new THREE.Box3().setFromObject(model);
                const size = box.getSize(new THREE.Vector3());
                const maxDim = Math.max(size.x, size.y, size.z);
                const targetSize = 2.5;
                const scale = targetSize / maxDim;
                model.scale.setScalar(scale);

                const center = box.getCenter(new THREE.Vector3());
                model.position.set(-center.x * scale, -center.y * scale, -center.z * scale);

                model.traverse((c) => {
                    if (c.isMesh) {
                        c.castShadow = true;
                        c.receiveShadow = true;
                        if (c.material) {
                            if (Array.isArray(c.material)) {
                                c.material.forEach(m => { m.envMapIntensity = 0.6; });
                            } else {
                                c.material.envMapIntensity = 0.6;
                            }
                        }
                    }
                });

                this.burgerGroup.add(model);

                this.addAOShadow(1.5, 0.18, 0.12);
                this.addAOShadow(1.4, 0.10, 0.10);
                this.addAOShadow(1.3, 0.00, 0.10);
                this.addAOShadow(1.3, -0.08, 0.08);

                const burgerX = this.isMobile ? 0 : (this.isTablet ? 1.2 : 2.5);
                this.burgerGroup.position.set(burgerX, -0.15, 0);
                this.scene.add(this.burgerGroup);

                this.modelLoaded = true;
            },
            undefined,
            (err) => {
                console.warn('Burger GLB failed to load:', err);
            }
        );
    }

    addAOShadow(radius, yPos, opacity = 0.15) {
        const geo = new THREE.RingGeometry(radius * 0.4, radius, 32);
        const mat = new THREE.MeshBasicMaterial({
            color: 0x000000,
            transparent: true,
            opacity: opacity,
            side: THREE.DoubleSide,
            depthWrite: false,
            blending: THREE.MultiplyBlending,
        });
        const mesh = new THREE.Mesh(geo, mat);
        mesh.rotation.x = -Math.PI / 2;
        mesh.position.set(0, yPos, 0);
        this.burgerGroup.add(mesh);
    }

    createLighting() {
        const ambient = new THREE.AmbientLight(0x333355, 0.25);
        this.scene.add(ambient);

        const key = new THREE.DirectionalLight(0xffd4a0, 6.0);
        key.position.set(4, 7, 4);
        key.castShadow = true;
        key.shadow.mapSize.width = 2048;
        key.shadow.mapSize.height = 2048;
        key.shadow.radius = 12;
        key.shadow.bias = -0.003;
        this.scene.add(key);

        const fill = new THREE.DirectionalLight(0x6688cc, 1.2);
        fill.position.set(-5, 1, -4);
        this.scene.add(fill);

        const rim = new THREE.DirectionalLight(0xff8844, 2.5);
        rim.position.set(0, 2, -7);
        this.scene.add(rim);

        const backRim = new THREE.DirectionalLight(0xff6622, 0.8);
        backRim.position.set(3, 0, -6);
        this.scene.add(backRim);

        const warm = new THREE.PointLight(0xff5500, 1.5, 5);
        warm.position.set(2.8, -0.3, 0.3);
        this.scene.add(warm);
        this.glowLights.push(warm);

        const cool = new THREE.PointLight(0x4488ff, 0.5, 4);
        cool.position.set(-1.5, 0.3, 1.5);
        this.scene.add(cool);
    }

    createOrangeGlow() {
        const glowGeo = new THREE.PlaneGeometry(8, 8);
        const glowMat = new THREE.MeshBasicMaterial({
            color: 0xff5500,
            transparent: true,
            opacity: 0.06,
            blending: THREE.AdditiveBlending,
            depthWrite: false,
            side: THREE.DoubleSide,
        });
        const glow = new THREE.Mesh(glowGeo, glowMat);
        glow.position.set(2.5, -0.2, -1.5);
        glow.name = 'burger-glow';
        this.scene.add(glow);

        const glowGeo2 = new THREE.PlaneGeometry(5, 5);
        const glowMat2 = glowMat.clone();
        glowMat2.color.setHex(0xff3300);
        glowMat2.opacity = 0.04;
        const glow2 = new THREE.Mesh(glowGeo2, glowMat2);
        glow2.position.set(2.8, -0.5, -1.0);
        glow2.name = 'burger-glow-2';
        this.scene.add(glow2);
    }

    createFloatingIngredients() {
        const types = [
            { geo: new THREE.SphereGeometry(0.06, 8, 8), color: 0xff6633 },
            { geo: new THREE.TorusGeometry(0.05, 0.02, 6, 12), color: 0xcc88aa },
            { geo: new THREE.CylinderGeometry(0.04, 0.04, 0.015, 6), color: 0x66aa44 },
            { geo: new THREE.BoxGeometry(0.07, 0.015, 0.07), color: 0xffdd44 },
            { geo: new THREE.TorusKnotGeometry(0.04, 0.015, 24, 8), color: 0xcc3333 },
        ];
        const count = this.isMobile ? 15 : this.isTablet ? 25 : 40;
        for (let i = 0; i < count; i++) {
            const type = types[i % types.length];
            const mat = new THREE.MeshStandardMaterial({
                color: type.color, roughness: 0.5, metalness: 0.1,
                transparent: true, opacity: 0.5 + Math.random() * 0.3,
            });
            const mesh = new THREE.Mesh(type.geo, mat);
            const radius = 1.8 + Math.random() * 3.5;
            const theta = Math.random() * Math.PI * 2;
            const height = (Math.random() - 0.5) * 2.5;
            mesh.position.set(Math.cos(theta) * radius, height, Math.sin(theta) * radius);
            mesh.userData = {
                speed: 0.15 + Math.random() * 0.3, theta, radius, height,
                floatSpeed: 0.3 + Math.random() * 0.5, floatOffset: Math.random() * Math.PI * 2,
                rotationSpeed: 0.5 + Math.random() * 2,
                rotAxis: new THREE.Vector3(Math.random() - 0.5, Math.random() - 0.5, Math.random() - 0.5).normalize(),
                orbitSpeed: 0.02 + Math.random() * 0.04 * (Math.random() > 0.5 ? 1 : -1),
            };
            mesh.castShadow = true;
            this.scene.add(mesh);
            this.floatingIngredients.push(mesh);
        }
    }

    createParticleSystem() {
        const count = this.isMobile ? 200 : 600;
        const positions = new Float32Array(count * 3);
        const colors = new Float32Array(count * 3);
        const sizes = new Float32Array(count);
        for (let i = 0; i < count; i++) {
            const radius = 1.5 + Math.random() * 7;
            const theta = Math.random() * Math.PI * 2;
            const phi = Math.acos(2 * Math.random() - 1);
            positions[i * 3] = Math.sin(phi) * Math.cos(theta) * radius;
            positions[i * 3 + 1] = (Math.random() - 0.5) * 4;
            positions[i * 3 + 2] = Math.sin(phi) * Math.sin(theta) * radius;
            const c = new THREE.Color().setHSL(0.08 + Math.random() * 0.05, 0.5, 0.3 + Math.random() * 0.2);
            colors[i * 3] = c.r; colors[i * 3 + 1] = c.g; colors[i * 3 + 2] = c.b;
            sizes[i] = 0.01 + Math.random() * 0.04;
        }
        const geometry = new THREE.BufferGeometry();
        geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
        geometry.setAttribute('color', new THREE.BufferAttribute(colors, 3));
        geometry.setAttribute('size', new THREE.BufferAttribute(sizes, 1));
        const material = new THREE.PointsMaterial({
            size: 0.03, transparent: true, opacity: 0.3, blending: THREE.AdditiveBlending,
            sizeAttenuation: true, vertexColors: true, depthWrite: false,
        });
        this.particles = new THREE.Points(geometry, material);
        this.scene.add(this.particles);
    }

    createSmokeSystem() {
        const count = this.isMobile ? 15 : 40;
        const geometry = new THREE.BufferGeometry();
        const positions = new Float32Array(count * 3);
        const sizes = new Float32Array(count);
        this.smokeVelocities = [];
        this.smokeLifetimes = [];
        for (let i = 0; i < count; i++) {
            positions[i * 3] = (Math.random() - 0.5) * 0.6;
            positions[i * 3 + 1] = -0.2 + Math.random() * 0.1;
            positions[i * 3 + 2] = (Math.random() - 0.5) * 0.6;
            sizes[i] = 0.05 + Math.random() * 0.15;
            this.smokeVelocities.push({
                x: (Math.random() - 0.5) * 0.008, y: 0.01 + Math.random() * 0.02, z: (Math.random() - 0.5) * 0.008,
            });
            this.smokeLifetimes.push(Math.random() * 4);
        }
        geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
        geometry.setAttribute('size', new THREE.BufferAttribute(sizes, 1));
        this.smokeParticles = new THREE.Points(geometry, new THREE.PointsMaterial({
            color: 0x884422, size: 0.12, transparent: true, opacity: 0.12,
            blending: THREE.AdditiveBlending, sizeAttenuation: true, depthWrite: false,
        }));
        this.smokeParticles.position.y = -0.3;
        this.scene.add(this.smokeParticles);
    }

    createGroundPlane() {
        const ground = new THREE.Mesh(
            new THREE.CircleGeometry(4, 48),
            new THREE.MeshStandardMaterial({ color: 0x0a0a0f, roughness: 1, metalness: 0, transparent: true, opacity: 0.5 })
        );
        ground.rotation.x = -Math.PI / 2;
        ground.position.y = -0.7;
        ground.receiveShadow = true;
        this.scene.add(ground);
        const ring = new THREE.Mesh(
            new THREE.RingGeometry(0.5, 2.0, 48),
            new THREE.MeshBasicMaterial({ color: 0xff8833, transparent: true, opacity: 0.05, side: THREE.DoubleSide })
        );
        ring.rotation.x = -Math.PI / 2;
        ring.position.y = -0.68;
        this.scene.add(ring);
    }

    bindEvents() {
        this.onResize = () => {
            const w = this.container.clientWidth;
            const h = this.container.clientHeight;
            this.camera.aspect = w / h;
            this.camera.updateProjectionMatrix();
            this.renderer.setSize(w, h);
            this.composer.setSize(w, h);
            this.isMobile = window.innerWidth < 768;
            this.isTablet = window.innerWidth < 1024;
            if (this.burgerGroup) {
                this.burgerGroup.position.x = this.isMobile ? 0 : (this.isTablet ? 1.2 : 2.5);
            }
        };
        this.onMouseMove = (e) => {
            this.mouse.x = (e.clientX / window.innerWidth) * 2 - 1;
            this.mouse.y = -(e.clientY / window.innerHeight) * 2 + 1;
        };
        this.onScroll = () => { this.scrollY = window.scrollY; };
        window.addEventListener('resize', this.onResize);
        document.addEventListener('mousemove', this.onMouseMove);
        document.addEventListener('scroll', this.onScroll, { passive: true });
        if ('ontouchstart' in window) {
            document.addEventListener('touchmove', (e) => {
                if (e.touches.length === 1) {
                    this.mouse.x = (e.touches[0].clientX / window.innerWidth) * 2 - 1;
                    this.mouse.y = -(e.touches[0].clientY / window.innerHeight) * 2 + 1;
                }
            }, { passive: true });
        }
    }

    animate() {
        requestAnimationFrame(() => this.animate());
        const delta = Math.min(this.clock.getDelta(), 0.05);
        const elapsed = this.clock.getElapsedTime();

        if (this.burgerGroup) {
            const tx = this.mouse.y * 0.3;
            const ty = this.mouse.x * 0.5;
            this.targetRotation.x += (tx - this.targetRotation.x) * 0.05;
            this.targetRotation.y += (ty - this.targetRotation.y) * 0.05;
            this.burgerGroup.rotation.x = this.targetRotation.x;
            this.burgerGroup.rotation.y = this.targetRotation.y + elapsed * 0.12;
            const sf = Math.min(this.scrollY / (window.innerHeight * 0.8), 1);
            const e = 1 - Math.pow(1 - sf, 2);
            this.burgerGroup.position.y = -0.15 - e * 3;
            this.burgerGroup.scale.setScalar(Math.max(1 - e * 0.4, 0.6));
        }

        this.floatingIngredients.forEach(m => {
            const d = m.userData;
            const nt = d.theta + elapsed * d.orbitSpeed;
            const fy = Math.sin(elapsed * d.floatSpeed + d.floatOffset) * 0.15;
            m.position.x = Math.cos(nt) * d.radius;
            m.position.y = d.height + fy;
            m.position.z = Math.sin(nt) * d.radius;
            m.rotation.x += d.rotationSpeed * delta;
            m.rotation.y += d.rotationSpeed * delta * 0.7;
        });

        if (this.particles) {
            this.particles.rotation.y += delta * 0.015;
            this.particles.rotation.x = Math.sin(elapsed * 0.02) * 0.02;
        }

        if (this.smokeParticles && this.smokeVelocities.length) {
            const p = this.smokeParticles.geometry.attributes.position.array;
            for (let i = 0; i < p.length / 3; i++) {
                p[i * 3] += this.smokeVelocities[i].x;
                p[i * 3 + 1] += this.smokeVelocities[i].y;
                p[i * 3 + 2] += this.smokeVelocities[i].z;
                this.smokeLifetimes[i] += delta;
                if (this.smokeLifetimes[i] > 3 + Math.random()) {
                    p[i * 3] = (Math.random() - 0.5) * 0.6;
                    p[i * 3 + 1] = -0.2;
                    p[i * 3 + 2] = (Math.random() - 0.5) * 0.6;
                    this.smokeLifetimes[i] = 0;
                    this.smokeVelocities[i] = { x: (Math.random() - 0.5) * 0.008, y: 0.01 + Math.random() * 0.02, z: (Math.random() - 0.5) * 0.008 };
                }
            }
            this.smokeParticles.geometry.attributes.position.needsUpdate = true;
        }

        this.glowLights.forEach((l, i) => { l.intensity = 1.5 + Math.sin(elapsed * 0.5 + i) * 0.5; });

        const cb = Math.sin(elapsed * 0.1) * 0.05;
        this.camera.position.x += (this.mouse.x * 0.4 - this.camera.position.x + cb) * 0.008;
        this.camera.position.y += (0.9 - this.mouse.y * 0.2 - this.camera.position.y) * 0.008;
        this.camera.lookAt(0, 0.05, 0);

        if (this.composer) this.composer.render();
        else this.renderer.render(this.scene, this.camera);
    }

    dispose() {
        window.removeEventListener('resize', this.onResize);
        document.removeEventListener('mousemove', this.onMouseMove);
        document.removeEventListener('scroll', this.onScroll);
        if (this.composer) this.composer.dispose();
        this.renderer.dispose();
        this.scene.traverse(c => {
            if (c.isMesh) {
                c.geometry.dispose();
                if (Array.isArray(c.material)) c.material.forEach(m => m.dispose());
                else c.material.dispose();
            }
        });
    }
}

let sceneInstance = null;
export function initScene() {
    if (!sceneInstance) sceneInstance = new Burger3DScene();
    return sceneInstance;
}
export function destroyScene() {
    if (sceneInstance) { sceneInstance.dispose(); sceneInstance = null; }
}
if (typeof window !== 'undefined') {
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', () => initScene());
    else initScene();
}
