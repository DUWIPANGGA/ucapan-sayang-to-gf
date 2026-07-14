// === Valentine's Day App ===

const userImages = window.appImages || [];
let currentStep = 1;
let loveModeOn = false;
let tttBoard = Array(9).fill(null);
let userTurn = true;
let gameWinner = null;
let twText = 'Happy Valentine!!!!';
let twDisplayed = '';
let twDeleting = false;
let twTimeout = null;
let lovePct = 0;

// === Init ===
document.addEventListener('DOMContentLoaded', () => {
    createHearts();
    showStep(1);
    setupTicTacToe();
});

// === Floating Hearts ===
function createHearts() {
    const c = document.getElementById('floating-hearts');
    if (!c) return;
    for (let i = 0; i < 10; i++) {
        const h = document.createElement('div');
        h.className = 'float-heart';
        h.innerHTML = '<svg viewBox="0 0 24 24" fill="currentColor" width="30" height="30"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>';
        h.style.left = `${(i * 10) + Math.random() * 5}%`;
        h.style.animationDuration = `${15 + Math.random() * 10}s`;
        h.style.animationDelay = `${i * 2}s`;
        h.style.fontSize = `${20 + Math.random() * 20}px`;
        c.appendChild(h);
    }
}

// === Steps ===
function showStep(n) {
    for (let i = 1; i <= 4; i++) {
        const el = document.getElementById(`step-${i}`);
        if (el) el.style.display = i === n ? 'flex' : 'none';
    }
    currentStep = n;
    if (n === 3) startMeter();
    if (n === 4) startTypewriter();
}

function transitionStep(next) {
    const cur = document.getElementById(`step-${currentStep}`);
    if (cur) {
        cur.classList.add('fade-out');
        setTimeout(() => showStep(next), 500);
    }
}

// === Step 1: Love Mode ===
document.getElementById('love-btn')?.addEventListener('click', () => {
    loveModeOn = !loveModeOn;
    const btn = document.getElementById('love-btn');
    const card = document.getElementById('love-card');
    const heart = document.getElementById('heart-icon');
    const txt = document.getElementById('love-text');
    const loff = document.getElementById('label-off');
    const lon = document.getElementById('label-on');

    if (loveModeOn) {
        btn.classList.add('active');
        card.classList.add('active');
        heart.classList.replace('heart-off', 'heart-on');
        txt.classList.replace('text-off', 'text-on');
        loff.classList.replace('label-active', 'label-inactive');
        lon.classList.replace('label-inactive', 'label-active');
        setTimeout(() => { if (loveModeOn) transitionStep(2); }, 3000);
    } else {
        btn.classList.remove('active');
        card.classList.remove('active');
        heart.classList.replace('heart-on', 'heart-off');
        txt.classList.replace('text-on', 'text-off');
        loff.classList.replace('label-inactive', 'label-active');
        lon.classList.replace('label-active', 'label-inactive');
    }
});

// === Step 2: Tic-Tac-Toe ===
const LINES = [[0,1,2],[3,4,5],[6,7,8],[0,3,6],[1,4,7],[2,5,8],[0,4,8],[2,4,6]];

function checkWin(b) {
    for (const [a, c, d] of LINES) {
        if (b[a] && b[a] === b[c] && b[a] === b[d]) return b[a];
    }
    return b.includes(null) ? null : 'draw';
}

function setupTicTacToe() {
    document.querySelectorAll('.ttt-cell').forEach(cell => {
        cell.addEventListener('click', () => {
            const i = parseInt(cell.dataset.index);
            if (tttBoard[i] || gameWinner || !userTurn) return;
            tttBoard[i] = 'X';
            renderCell(i, 'X');
            const r = checkWin(tttBoard);
            if (r) { gameWinner = r; endGame(r); return; }
            userTurn = false;
            setTimeout(aiMove, 600);
        });
    });
}

function aiMove() {
    const empty = tttBoard.map((v, i) => v === null ? i : null).filter(v => v !== null);
    if (!empty.length) return;
    const nonCenter = empty.filter(i => i !== 4);
    const idx = nonCenter.length ? nonCenter[Math.floor(Math.random() * nonCenter.length)] : 4;
    tttBoard[idx] = 'O';
    renderCell(idx, 'O');
    const r = checkWin(tttBoard);
    if (r) { gameWinner = r; endGame(r); }
    else userTurn = true;
}

function renderCell(i, p) {
    const el = document.getElementById(`cell-${i}`);
    if (!el) return;
    el.innerHTML = p === 'X'
        ? '<span class="cell-x">\u2715</span>'
        : '<span class="cell-o">\u25CB</span>';
}

function endGame(r) {
    const msg = document.getElementById('ttt-msg');
    const res = document.getElementById('ttt-result');
    if (r === 'X') {
        msg.textContent = 'Kamu Memenangkan';
        for (let i = 0; i < 9; i++) {
            if (tttBoard[i] === 'X') {
                const el = document.getElementById(`cell-${i}`);
                if (el) setTimeout(() => { el.innerHTML = '<span class="cell-heart">\u2764\uFE0F</span>'; }, i * 150);
            }
        }
        res.classList.remove('hidden');
        res.textContent = 'Hatiku';
        setTimeout(() => transitionStep(3), 3500);
    } else {
        msg.textContent = r === 'draw' ? 'Seri! Coba lagi yaa \u2764\uFE0F' : 'Hampir! Sekali lagi...';
        setTimeout(() => {
            tttBoard = Array(9).fill(null);
            gameWinner = null;
            userTurn = true;
            for (let i = 0; i < 9; i++) {
                const el = document.getElementById(`cell-${i}`);
                if (el) el.innerHTML = '';
            }
            msg.textContent = "Let's play a little game...";
        }, 1500);
    }
}

// === Step 3: Love Meter ===
function startMeter() {
    lovePct = 0;
    const circ = 282.74;
    const iv = setInterval(() => {
        lovePct++;
        const arc = document.getElementById('meter-arc');
        const pctEl = document.getElementById('love-pct');
        const bar = document.getElementById('progress-fill');
        if (arc) arc.setAttribute('stroke-dashoffset', circ - (lovePct / 100) * circ);
        if (pctEl) pctEl.textContent = lovePct;
        if (bar) bar.style.width = `${lovePct}%`;
        if (lovePct >= 100) {
            clearInterval(iv);
            setTimeout(() => transitionStep(4), 1500);
        }
    }, 40);
}

// === Step 4: Typewriter ===
function startTypewriter() {
    twDisplayed = '';
    twDeleting = false;
    typeLoop();
}

function typeLoop() {
    const el = document.getElementById('tw-display');
    if (!el) return;
    if (!twDeleting && twDisplayed !== twText) {
        twDisplayed = twText.slice(0, twDisplayed.length + 1);
        el.textContent = twDisplayed;
        twTimeout = setTimeout(typeLoop, 150);
    } else if (!twDeleting && twDisplayed === twText) {
        twTimeout = setTimeout(() => { twDeleting = true; typeLoop(); }, 2500);
    } else if (twDeleting && twDisplayed !== '') {
        twDisplayed = twText.slice(0, twDisplayed.length - 1);
        el.textContent = twDisplayed;
        twTimeout = setTimeout(typeLoop, 80);
    } else if (twDeleting && twDisplayed === '') {
        showGallery();
    }
}

// === Dome Gallery ===
let rotX = 0, rotY = 0, dragging = false, startRot = { x: 0, y: 0 }, startPos = null, lastEnd = 0;
let autoRAF = null, focusedEl = null, segments = 34;

function showGallery() {
    document.getElementById('interaction-flow').style.display = 'none';
    document.getElementById('dome-gallery').classList.remove('hidden');
    initDome();
}

function initDome() {
    const sphere = document.getElementById('sphere');
    if (!sphere) return;
    buildSphere(sphere);
    startAuto();
    setupDrag();
    setupScrim();
}

function buildSphere(sphere) {
    const radius = Math.min(window.innerWidth, window.innerHeight) * 0.8;
    const evenYs = [-4, -2, 0, 2, 4];
    const oddYs = [-3, -1, 1, 3, 5];
    const coords = [];
    for (let c = 0; c < segments; c++) {
        const x = -37 + c * 2;
        (c % 2 === 0 ? evenYs : oddYs).forEach(y => coords.push({ x, y, sX: 2, sY: 2 }));
    }
    sphere.style.setProperty('--radius', `${radius}px`);
    const unit = 360 / segments / 2;

    coords.forEach((co, i) => {
        const src = userImages[i % userImages.length] || '';
        const rY = unit * (co.x + (co.sX - 1) / 2);
        const rX = unit * (co.y - (co.sY - 1) / 2);
        const item = document.createElement('div');
        item.className = 'sphere-item';
        item.style.cssText = `width:${(360/segments)*co.sX}px;height:${(360/segments)*co.sY}px;transform:rotateY(${rY}deg) rotateX(${-rX}deg) translateZ(${radius}px);`;
        const wrap = document.createElement('div');
        wrap.className = 'item-img';
        wrap.dataset.src = src;
        const img = document.createElement('img');
        img.src = src; img.alt = `Photo ${i+1}`; img.draggable = false;
        wrap.appendChild(img);
        item.appendChild(wrap);
        sphere.appendChild(item);
        wrap.addEventListener('click', () => {
            if (dragging || performance.now() - lastEnd < 80) return;
            openImage(wrap);
        });
    });
}

function applyRot(x, y) {
    const s = document.getElementById('sphere');
    if (s) s.style.transform = `translateZ(calc(var(--radius) * -1)) rotateX(${x}deg) rotateY(${y}deg)`;
}

function startAuto() {
    (function loop() {
        if (!dragging && !focusedEl) {
            rotY = ((rotY + 0.1) % 360 + 360) % 360;
            applyRot(rotX, rotY);
        }
        autoRAF = requestAnimationFrame(loop);
    })();
}

function clamp(v, mn, mx) { return Math.min(Math.max(v, mn), mx); }

function setupDrag() {
    const stage = document.querySelector('.dome-stage');
    if (!stage) return;
    stage.addEventListener('pointerdown', e => {
        if (focusedEl) return;
        dragging = true; startPos = { x: e.clientX, y: e.clientY };
        startRot = { x: rotX, y: rotY };
        stage.setPointerCapture(e.pointerId);
    });
    stage.addEventListener('pointermove', e => {
        if (!dragging || !startPos) return;
        const dx = e.clientX - startPos.x, dy = e.clientY - startPos.y;
        rotX = clamp(startRot.x - dy / 20, -5, 5);
        rotY = startRot.y + dx / 20;
        applyRot(rotX, rotY);
    });
    stage.addEventListener('pointerup', () => {
        dragging = false; lastEnd = performance.now(); startPos = null;
    });
}

function openImage(el) {
    if (focusedEl) return;
    focusedEl = el;
    document.body.classList.add('scroll-locked');
    const src = el.dataset.src;
    const frame = document.getElementById('viewer-frame');
    const scrim = document.getElementById('scrim');
    const overlay = document.createElement('div');
    overlay.className = 'enlarge';
    const img = document.createElement('img');
    img.src = src; overlay.appendChild(img);
    frame.appendChild(overlay);
    scrim.classList.add('active');
    requestAnimationFrame(() => { overlay.style.opacity = '1'; });
    const v = document.getElementById('viewer');
    const lL = document.createElement('div');
    lL.className = 'romantic-label label-left'; lL.textContent = 'My';
    const lR = document.createElement('div');
    lR.className = 'romantic-label label-right'; lR.textContent = 'Everything';
    v.appendChild(lL); v.appendChild(lR);
    setTimeout(() => { lL.classList.add('show'); lR.classList.add('show'); }, 300);
}

function closeImage() {
    const ov = document.querySelector('.enlarge');
    const scrim = document.getElementById('scrim');
    const v = document.getElementById('viewer');
    if (ov) { ov.style.opacity = '0'; setTimeout(() => ov.remove(), 300); }
    scrim.classList.remove('active');
    v.querySelectorAll('.romantic-label').forEach(el => {
        el.classList.remove('show');
        setTimeout(() => el.remove(), 500);
    });
    document.body.classList.remove('scroll-locked');
    focusedEl = null;
}

function setupScrim() {
    document.getElementById('scrim')?.addEventListener('click', closeImage);
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeImage(); });
}
