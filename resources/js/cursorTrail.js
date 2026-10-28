// Spawns falling 0/1 "bits" behind the mouse. Needs an element with id="trail-stage".
export function initCursorTrail() {
    const stage = document.getElementById('trail-stage');
    if (!stage) return;

    let lastSpawn = 0;
    const spawnInterval = 40;

    function spawnBit(x, y) {
        const bit = document.createElement('div');
        bit.className = 'bit';
        bit.textContent = Math.random() < 0.5 ? '0' : '1';

        bit.style.left = x + (Math.random() - 0.5) * 14 + 'px';
        bit.style.top = y + (Math.random() - 0.5) * 14 + 'px';
        bit.style.fontSize = 14 * (0.8 + Math.random() * 0.6) + 'px';

        stage.appendChild(bit);
        bit.addEventListener('animationend', () => bit.remove());
    }

    window.addEventListener('mousemove', (e) => {
        const now = performance.now();
        if (now - lastSpawn > spawnInterval) {
            spawnBit(e.clientX, e.clientY);
            lastSpawn = now;
        }
    });
}
