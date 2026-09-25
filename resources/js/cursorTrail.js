export function initCursorTrail() {
    const stage = document.getElementById('trail-stage');
    if (!stage) return;

    let lastSpawn = 0;
    const spawnInterval = 40;

    function spawnBit(x, y) {
        const bit = document.createElement('div');
        bit.className = 'bit';
        bit.textContent = Math.random() < 0.5 ? '0' : '1';

        const offsetX = (Math.random() - 0.5) * 14;
        const offsetY = (Math.random() - 0.5) * 14;
        bit.style.left = (x + offsetX) + 'px';
        bit.style.top = (y + offsetY) + 'px';   // was .right — fixed

        const scale = 0.8 + Math.random() * 0.6;
        bit.style.fontSize = (14 * scale) + 'px';

        stage.appendChild(bit);
        bit.addEventListener('animationend', () => bit.remove());
    }

    // moved out here — this is what was missing
    window.addEventListener('mousemove', (e) => {
        const now = performance.now();
        if (now - lastSpawn > spawnInterval) {
            spawnBit(e.clientX, e.clientY);
            lastSpawn = now;
        }
    });
}