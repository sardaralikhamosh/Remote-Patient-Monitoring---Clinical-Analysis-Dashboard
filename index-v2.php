<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>RPM Clinical Analysis Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* Base styles remain the same */
* { margin:0; padding:0; box-sizing:border-box; }

:root {
    --primary-bg:#ffffff;
    --secondary-bg:#f8f9fa;
    --border:#e0e5eb;
    --txt:#1a1f36;
    --txt2:#697386;
    --red:#ef4444;
    --amber:#f59e0b;
    --green:#10b981;
    --grey:#6b7280;
    --teal:#0891b2;
    --orange:#f97316;
}

body {
    font-family:'Inter',-apple-system,sans-serif;
    background:var(--secondary-bg);
    color:var(--txt);
    line-height:1.5;
    margin:0; padding:0;
}

/* Controls Bar */
.controls-bar {
    background:linear-gradient(135deg,#667eea,#764ba2);
    padding:10px 24px;
    display:flex; gap:12px;
    align-items:center; justify-content:flex-end;
    box-shadow:0 2px 8px rgba(0,0,0,.12);
}
.btn {
    padding:9px 18px; border:none; border-radius:6px;
    font:600 13px/1 'Inter',sans-serif;
    cursor:pointer; display:flex; align-items:center; gap:6px;
    transition:all .2s;
}
.btn:hover { transform:translateY(-1px); box-shadow:0 4px 10px rgba(0,0,0,.18); }
.btn-reset { background:#ef4444; color:#fff; }
.btn-reset:hover { background:#dc2626; }
.btn-print { background:#fff; color:#667eea; }
.btn-print:hover { background:#f0f4ff; }

/* Header */
.header {
    background:linear-gradient(135deg,#1a1f36,#2d3748);
    color:#fff; padding:14px 28px;
    box-shadow:0 2px 4px rgba(0,0,0,.1);
}
.header h1 { font-size:18px; font-weight:700; margin-bottom:2px; }
.header p  { font-size:11px; opacity:.85; }

/* Main Grid */
.main-layout {
    display:grid;
    grid-template-columns:30% 70%;
    background:#fff;
}

.left-column {
    background:#fafbfc;
    border-right:2px solid var(--border);
    padding:16px 14px;
    display:flex; flex-direction:column; gap:14px;
}

.right-column {
    padding:16px 20px;
    display:flex; flex-direction:column; gap:16px;
}

/* Traffic Light */
.tl-wrap {
    background:#2d3748;
    padding:14px 18px;
    border-radius:22px;
    box-shadow:0 4px 12px rgba(0,0,0,.15);
    margin:0 auto;
}
.tl { display:flex; gap:14px; justify-content:center; }
.lw { position:relative; }
.light {
    width:48px; height:48px; border-radius:50%; cursor:pointer;
    transition:all .3s cubic-bezier(.4,0,.2,1);
    box-shadow:inset 0 2px 8px rgba(0,0,0,.3);
    position:relative;
}
.light::after {
    content:''; position:absolute; inset:7px; border-radius:50%;
    background:linear-gradient(135deg,rgba(255,255,255,.4),transparent);
}
.light:hover { transform:scale(1.08); }
.light.c-red    { background:#ef4444; box-shadow:0 0 22px rgba(239,68,68,.6),inset 0 2px 8px rgba(0,0,0,.3); }
.light.c-yellow { background:#f59e0b; box-shadow:0 0 22px rgba(245,158,11,.6),inset 0 2px 8px rgba(0,0,0,.3); }
.light.c-green  { background:#10b981; box-shadow:0 0 22px rgba(16,185,129,.6),inset 0 2px 8px rgba(0,0,0,.3); }
.light.c-grey   { background:#6b7280; box-shadow:inset 0 2px 8px rgba(0,0,0,.3); }

.col-drop {
    position:absolute; top:58px; left:50%; transform:translateX(-50%);
    background:#fff; border-radius:10px; padding:6px;
    box-shadow:0 8px 24px rgba(0,0,0,.2);
    display:none; z-index:1000; border:1px solid var(--border);
}
.col-drop.open { display:block; }
.col-opt {
    width:34px; height:34px; border-radius:50%; margin:3px; cursor:pointer;
    transition:all .2s; border:3px solid transparent;
    box-shadow:0 2px 6px rgba(0,0,0,.15); display:inline-block;
}
.col-opt:hover { transform:scale(1.18); border-color:#667eea; }
.col-opt.red    { background:#ef4444; }
.col-opt.yellow { background:#f59e0b; }
.col-opt.green  { background:#10b981; }
.col-opt.grey   { background:#6b7280; }

/* Risk Factors */
.section-hd {
    font-size:13px; font-weight:700; color:var(--txt);
    display:flex; justify-content:space-between; align-items:center;
    margin-bottom:8px;
}
.risk-list {
    background:#fff; border-radius:8px; padding:10px;
    border:1px solid var(--border);
}
.risk-item {
    display:flex; gap:5px; margin-bottom:7px;
    font-size:11.5px; line-height:1.45; align-items:flex-start;
}
.risk-item:last-child { margin-bottom:0; }
.risk-num { flex-shrink:0; font-weight:700; color:var(--red); min-width:18px; padding-top:1px; }
.risk-txt {
    flex:1; border:1px solid transparent; border-radius:4px;
    padding:3px 5px; background:transparent; transition:all .2s;
    font-size:11.5px; line-height:1.4;
}
.risk-txt:focus { outline:none; border-color:#667eea; background:#f0f4ff; }
.risk-txt[contenteditable="true"]:hover { background:#fafbfc; border-color:var(--border); }

/* Control Buttons */
.cb {
    width:20px; height:20px; border:none; border-radius:50%;
    cursor:pointer; display:flex; align-items:center; justify-content:center;
    font-size:13px; line-height:1; transition:all .15s;
    flex-shrink:0; padding:0;
}
.cb:hover { transform:scale(1.18); }
.cb.add { background:#10b981; color:#fff; }
.cb.add:hover { background:#059669; }
.cb.del { background:#ef4444; color:#fff; }
.cb.del:hover { background:#dc2626; }

/* IMAGE PASTE BOX - COMPLETELY FIXED */
.paste-box-outer {
    border:1px solid var(--border);
    border-radius:8px;
    background:#fff;
    overflow:hidden;
    position: relative;
    min-height: 200px;
}

/* Toolbar */
.paste-toolbar {
    display:flex; align-items:center; gap:6px;
    padding:6px 8px;
    background:#f4f6f8;
    border-bottom:1px solid var(--border);
    flex-wrap:wrap;
}
.paste-toolbar .tb-label {
    font-size:10px; font-weight:600; color:var(--txt2);
    white-space:nowrap;
}
.paste-toolbar .tb-btn {
    padding:3px 8px; border:1px solid var(--border); border-radius:4px;
    background:#fff; font-size:10px; font-weight:600; color:var(--txt);
    cursor:pointer; transition:all .15s; white-space:nowrap;
}
.paste-toolbar .tb-btn:hover { background:#f0f4ff; border-color:#667eea; color:#667eea; }
.paste-toolbar .tb-btn.danger { color:var(--red); }
.paste-toolbar .tb-btn.danger:hover { background:#fef2f2; border-color:var(--red); }

/* Upload button wrapper */
.upload-btn-wrap {
    position: relative;
    display: inline-block;
}
.upload-btn-wrap input[type="file"] {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
    z-index: 2;
}
.upload-btn-wrap .tb-btn {
    position: relative;
    z-index: 1;
    pointer-events: none;
}

/* Size slider */
.size-row {
    display:none;
    align-items:center; gap:6px;
    padding:5px 8px;
    background:#f9fafb;
    border-bottom:1px solid var(--border);
}
.size-row.visible { display: flex; }
.size-row label { font-size:10px; font-weight:600; color:var(--txt2); white-space:nowrap; }
.size-row input[type=range] {
    flex:1; height:4px;
    -webkit-appearance:none; appearance:none;
    background:#cbd5e0; border-radius:2px; outline:none;
}
.size-row input[type=range]::-webkit-slider-thumb {
    -webkit-appearance:none; appearance:none;
    width:14px; height:14px; border-radius:50%;
    background:#667eea; cursor:pointer;
}
.size-row input[type=range]::-moz-range-thumb {
    width:14px; height:14px; border-radius:50%;
    background:#667eea; cursor:pointer; border:none;
}
.size-row .sz-val { font-size:10px; font-weight:700; color:#667eea; min-width:28px; text-align:right; }

/* Paste zone */
.paste-inner {
    width: 100%;
    min-height: 150px;
    background: #fff;
    position: relative;
    outline: none;
    padding: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.paste-inner:focus {
    box-shadow: inset 0 0 0 2px #667eea;
}
.paste-inner.dragover {
    background: #eef2ff;
}

/* Placeholder */
.paste-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 20px;
    cursor: pointer;
    user-select: none;
}
.paste-placeholder .ph-icon { font-size: 32px; margin-bottom: 8px; }
.paste-placeholder .ph-txt {
    font-size: 11px; color: var(--txt2); font-weight: 500;
    text-align: center; line-height: 1.6;
}

/* The displayed image */
#pastedImg {
    max-width: 100%;
    max-height: 400px;
    object-fit: contain;
    display: none;
}
#pastedImg.visible {
    display: block;
}

/* Metric Row */
.metric-row {
    display:grid;
    grid-template-columns:75% 25%;
    padding-bottom:16px;
    border-bottom:2px solid var(--border);
}
.metric-row:last-child { border-bottom:none; padding-bottom:0; }
.text-section { display:flex; flex-direction:column; gap:8px; }
.metric-header {
    display:flex; justify-content:space-between; align-items:center;
    margin-bottom:4px;
}
.date-inp {
    background:#1a1f36; color:#fff; border:none;
    padding:5px 10px; border-radius:6px;
    font:600 10px/1 'Inter',sans-serif;
    text-transform:uppercase; cursor:pointer; letter-spacing:.5px;
}
.date-inp::-webkit-calendar-picker-indicator { filter:invert(1); cursor:pointer; }
.m-title { font-size:20px; font-weight:800; letter-spacing:-.02em; text-transform:uppercase; }
.m-title.hospital { color:var(--red); }
.m-title.hhcahps  { color:var(--teal); }
.m-title.hospice  { color:var(--orange); }
.bullet-list {
    background:#fafbfc; border:1px solid var(--border);
    border-radius:8px; padding:12px;
}
.bullet-item {
    display:flex; gap:5px; margin-bottom:7px;
    font-size:11.5px; line-height:1.5; color:var(--txt); align-items:flex-start;
}
.bullet-item:last-child { margin-bottom:0; }
.bullet-item .bdot { flex-shrink:0; font-weight:700; padding-top:1px; }
.bullet-txt {
    flex:1; border:1px solid transparent; border-radius:4px;
    padding:2px 4px; background:transparent; transition:all .2s;
}
.bullet-txt:focus { outline:none; border-color:#667eea; background:#fff; }
.bullet-txt[contenteditable="true"]:hover { background:#fff; border-color:var(--border); }

/* Gauge */
.gauge-col { display:flex; flex-direction:column; gap:8px; align-items:center; }
.gauge-wrap { position:relative; width:100%; max-width:180px; aspect-ratio:1; }
canvas { width:100%; height:100%; }
.gauge-over {
    position:absolute; top:44%; left:50%; transform:translate(-50%,-50%);
    text-align:center; pointer-events:none;
}
.g-emoji { font-size:32px; display:block; margin-bottom:4px; }
.g-score { font-size:24px; font-weight:800; line-height:1; }
.g-label { font-size:9px; font-weight:600; color:var(--txt2); text-transform:uppercase; letter-spacing:.05em; margin-top:3px; }
.score-inp-wrap { width:100%; max-width:180px; }
.score-inp {
    width:100%; padding:7px; border:2px solid var(--border); border-radius:6px;
    font:700 15px/1 'Inter',sans-serif; text-align:center; transition:all .2s;
}
.score-inp:focus { outline:none; border-color:#667eea; box-shadow:0 0 0 3px rgba(102,126,234,.1); }
.g-legend {
    display:flex; justify-content:space-between; gap:3px;
    width:100%; max-width:180px; flex-wrap:wrap;
}
.g-leg-item { display:flex; align-items:center; gap:3px; font-size:7.5px; font-weight:600; text-transform:uppercase; white-space:nowrap; }
.g-leg-clr { width:9px; height:9px; border-radius:2px; flex-shrink:0; }

/* Print */
@media print {
    @page { size: A4 landscape; margin: 0; }
    html, body {
        width: 297mm; height: 210mm;
        overflow: hidden; background: #fff;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    .print-scale-root { width: 297mm; height: 210mm; transform-origin: top left; }
    .controls-bar, .cb, .paste-toolbar, .size-row, .score-inp-wrap, .col-drop { display:none !important; }
    [contenteditable="true"] { border:none !important; background:transparent !important; outline:none !important; }
    .paste-placeholder { display:none !important; }
    .paste-inner { min-height:0; padding:0; }
    #pastedImg { display:block !important; max-width:100% !important; }
}
</style>
</head>
<body>

<div class="print-scale-root" id="printRoot">

<!-- Controls -->
<div class="controls-bar">
    <button class="btn btn-reset" onclick="resetDashboard()">🔄 Reset</button>
    <button class="btn btn-print" onclick="printDashboard()">🖨️ Print</button>
</div>

<!-- Header -->
<div class="header">
    <h1>🏥 Remote Patient Monitoring – Clinical Analysis Dashboard</h1>
    <p>Comprehensive risk assessment and care coordination metrics | Generated by Clinical Care Team</p>
</div>

<!-- Main -->
<div class="main-layout">

<!-- LEFT COLUMN -->
<div class="left-column">

    <!-- Traffic Light -->
    <div class="tl-wrap">
        <div class="tl">
            <div class="lw">
                <div class="light c-grey" onclick="openDrop(0)"></div>
                <div class="col-drop" id="drop0">
                    <div class="col-opt red" onclick="setLight(0,'red')"></div>
                    <div class="col-opt yellow" onclick="setLight(0,'yellow')"></div>
                    <div class="col-opt green" onclick="setLight(0,'green')"></div>
                    <div class="col-opt grey" onclick="setLight(0,'grey')"></div>
                </div>
            </div>
            <div class="lw">
                <div class="light c-yellow" onclick="openDrop(1)"></div>
                <div class="col-drop" id="drop1">
                    <div class="col-opt red" onclick="setLight(1,'red')"></div>
                    <div class="col-opt yellow" onclick="setLight(1,'yellow')"></div>
                    <div class="col-opt green" onclick="setLight(1,'green')"></div>
                    <div class="col-opt grey" onclick="setLight(1,'grey')"></div>
                </div>
            </div>
            <div class="lw">
                <div class="light c-grey" onclick="openDrop(2)"></div>
                <div class="col-drop" id="drop2">
                    <div class="col-opt red" onclick="setLight(2,'red')"></div>
                    <div class="col-opt yellow" onclick="setLight(2,'yellow')"></div>
                    <div class="col-opt green" onclick="setLight(2,'green')"></div>
                    <div class="col-opt grey" onclick="setLight(2,'grey')"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Risk Factors -->
    <div>
        <div class="section-hd">
            High Risk Factors
            <button class="cb add" onclick="addRisk()">+</button>
        </div>
        <div class="risk-list" id="riskList"></div>
    </div>

    <!-- IMAGE BOX - FIXED -->
    <div class="paste-box-outer" id="pasteBoxOuter">
        <!-- Toolbar -->
        <div class="paste-toolbar">
            <span class="tb-label">Trend Graph</span>
            <label class="upload-btn-wrap">
                <span class="tb-btn">📂 Upload</span>
                <input type="file" id="fileIn" accept="image/*">
            </label>
            <button class="tb-btn danger" id="removeBtn" style="display:none;" onclick="clearImage()">✕ Remove</button>
        </div>

        <!-- Size slider -->
        <div class="size-row" id="sizeRow">
            <label>Size</label>
            <input type="range" id="sizeSlider" min="30" max="100" value="100" oninput="resizeImg(this.value)">
            <span class="sz-val" id="sizeVal">100%</span>
        </div>

        <!-- Paste zone -->
        <div class="paste-inner" id="pasteInner" tabindex="0">
            <div class="paste-placeholder" id="pastePlaceholder">
                <div class="ph-icon">📊</div>
                <div class="ph-txt">📋 Paste screenshot here (Ctrl+V)<br><span style="opacity:.7;">or click Upload / drag &amp; drop</span></div>
            </div>
            <img id="pastedImg" alt="Trend graph">
        </div>
    </div>

</div><!-- end left -->

<!-- RIGHT COLUMN -->
<div class="right-column">
    <!-- Rows with gauges remain the same... continuing in next part -->
    <!-- ROW 1 – Hospital Risk -->
    <div class="metric-row">
        <div class="text-section">
            <div class="metric-header">
                <input type="date" class="date-inp" id="date1" value="2024-06-24">
                <div class="m-title hospital">HOSPITAL RISK</div>
            </div>
            <div class="section-hd" style="margin-bottom:4px;">
                <span style="font-size:10px;color:var(--txt2);font-weight:600;">Clinical Notes</span>
                <button class="cb add" onclick="addBullet('bList1')">+</button>
            </div>
            <div class="bullet-list" id="bList1"></div>
        </div>
        <div class="gauge-col">
            <div class="score-inp-wrap"><input type="number" class="score-inp" id="si1" min="0" max="100" value="68" oninput="updScore(1,this.value)"></div>
            <div class="gauge-wrap">
                <canvas id="g1" width="400" height="400"></canvas>
                <div class="gauge-over">
                    <span class="g-emoji" id="e1">😟</span>
                    <div class="g-score" id="s1">68<span style="font-size:18px">%</span></div>
                    <div class="g-label">Risk Score</div>
                </div>
            </div>
            <div class="g-legend">
                <div class="g-leg-item"><div class="g-leg-clr" style="background:#10b981"></div><span>Good 0-33%</span></div>
                <div class="g-leg-item"><div class="g-leg-clr" style="background:#f59e0b"></div><span>Fair 34-66%</span></div>
                <div class="g-leg-item"><div class="g-leg-clr" style="background:#ef4444"></div><span>Poor 67-100%</span></div>
            </div>
        </div>
    </div>

    <!-- ROW 2 – HHCAHPS -->
    <div class="metric-row">
        <div class="text-section">
            <div class="metric-header">
                <input type="date" class="date-inp" id="date2" value="2024-06-24">
                <div class="m-title hhcahps">HHCAHPS</div>
            </div>
            <div class="section-hd" style="margin-bottom:4px;">
                <span style="font-size:10px;color:var(--txt2);font-weight:600;">Clinical Notes</span>
                <button class="cb add" onclick="addBullet('bList2')">+</button>
            </div>
            <div class="bullet-list" id="bList2"></div>
        </div>
        <div class="gauge-col">
            <div class="score-inp-wrap"><input type="number" class="score-inp" id="si2" min="0" max="100" value="70" oninput="updScore(2,this.value)"></div>
            <div class="gauge-wrap">
                <canvas id="g2" width="400" height="400"></canvas>
                <div class="gauge-over">
                    <span class="g-emoji" id="e2">😊</span>
                    <div class="g-score" id="s2">70<span style="font-size:18px">%</span></div>
                    <div class="g-label">HHCAHPS Score</div>
                </div>
            </div>
            <div class="g-legend">
                <div class="g-leg-item"><div class="g-leg-clr" style="background:#ef4444"></div><span>Poor 0-33%</span></div>
                <div class="g-leg-item"><div class="g-leg-clr" style="background:#f59e0b"></div><span>Fair 34-66%</span></div>
                <div class="g-leg-item"><div class="g-leg-clr" style="background:#10b981"></div><span>Good 67-100%</span></div>
            </div>
        </div>
    </div>

    <!-- ROW 3 – Hospice Need -->
    <div class="metric-row">
        <div class="text-section">
            <div class="metric-header">
                <input type="date" class="date-inp" id="date3" value="2024-06-24">
                <div class="m-title hospice">HOSPICE NEED</div>
            </div>
            <div class="section-hd" style="margin-bottom:4px;">
                <span style="font-size:10px;color:var(--txt2);font-weight:600;">Clinical Notes</span>
                <button class="cb add" onclick="addBullet('bList3')">+</button>
            </div>
            <div class="bullet-list" id="bList3"></div>
        </div>
        <div class="gauge-col">
            <div class="score-inp-wrap"><input type="number" class="score-inp" id="si3" min="0" max="100" value="70" oninput="updScore(3,this.value)"></div>
            <div class="gauge-wrap">
                <canvas id="g3" width="400" height="400"></canvas>
                <div class="gauge-over">
                    <span class="g-emoji" id="e3">😊</span>
                    <div class="g-score" id="s3">70<span style="font-size:18px">%</span></div>
                    <div class="g-label">Care Need Score</div>
                </div>
            </div>
            <div class="g-legend">
                <div class="g-leg-item"><div class="g-leg-clr" style="background:#ef4444"></div><span>Poor 0-33%</span></div>
                <div class="g-leg-item"><div class="g-leg-clr" style="background:#f59e0b"></div><span>Fair 34-66%</span></div>
                <div class="g-leg-item"><div class="g-leg-clr" style="background:#10b981"></div><span>Good 67-100%</span></div>
            </div>
        </div>
    </div>

</div><!-- end right -->
</div><!-- end main-layout -->
</div><!-- end printRoot -->

<script>
// Sample Data
const DATA = {
  risks:[
    "Indwelling Foley catheter with leaking and discomfort complications",
    "UTI risk 35-40% from catheter since 12/10/25",
    "Untreated Stage 1-2 HTN: BP 144-151/71 mmHg",
    "Zero antihypertensive medications despite age 79 and HTN",
    "History of falling without documented fall assessment",
    "Voiding trial scheduled 12/19/25 with 20-25% failure risk",
    "Incomplete medication list: only 2 medications documented",
    "Headaches potentially indicating uncontrolled hypertension symptoms",
    "Walker dependent with taxing effort limiting mobility",
    "Age 79 with stroke/MI risk 12-18% annually",
    "No orthostatic BP measurements despite fall history",
    "Tylenol 1000mg single dose exceeds recommended 650mg"
  ],
  hosp:[
    'David\'s Blood Pressure monitoring is critically absent with no BP readings documented despite HTN diagnosis and hydrochlorothiazide 12.5mg with hold parameter "if SBP &lt;110"; cannot assess control or hypotension risk',
    "David has engaged with care team through skilled nursing visits for complex wound care, colostomy management, and suprapubic catheter care at board and care facility",
    "David had 0 BP measurements documented despite HTN diagnosis requiring urgent monitoring establishment",
    "David has board and care facility caregivers providing 24-hour supervision and assistance as documented in clinical notes",
    "David has limited family support with emergency contact Louis Hernandez; caregivers at facility provide total assistance for mobility, transfers, and ADLs as needed"
  ],
  hhc:[
    "Katherine has routine contact with care team through scheduled skilled nursing (SN) and physical therapy (PT) visits",
    "Katherine has NOT initiated contact on her own via SMS or phone (no documentation of patient-initiated contact)",
    "Katherine's care team includes: Ana Moreno-Quirarte RN (medication review, assessment), Lindsay PTA (physical therapy visits), and physician oversight"
  ],
  hosp2:[
    "Katherine has NOT had a kidney transplant (no transplant history documented)",
    "Katherine's weight: Not documented in available records (weight monitoring needed)",
    'Katherine reports: "Lots of pain" documented in clinical notes; exhaustion documented as risk factor; pain management with ice/medication education provided',
    "Katherine does NOT have a stage 2 wound (surgical wound from right hip replacement; no current wound documented)"
  ]
};

// Risk List Functions
function mkRisk(txt, el){
  const d=document.createElement('div');
  d.className='risk-item';
  d.innerHTML=`<div class="risk-num"></div><div class="risk-txt" contenteditable="true">${txt}</div><button class="cb del" onclick="this.closest('.risk-item').remove();renum()">×</button>`;
  el.appendChild(d);
}
function renum(){
  document.querySelectorAll('#riskList .risk-num').forEach((n,i)=>n.textContent=(i+1)+'.');
}
function initRisks(){
  const el=document.getElementById('riskList');
  el.innerHTML='';
  DATA.risks.forEach(t=>mkRisk(t,el));
  renum();
}
function addRisk(){
  const el=document.getElementById('riskList');
  mkRisk('New risk factor…',el);
  renum();
  const last=[...el.querySelectorAll('.risk-txt')].pop();
  last.focus();
  const r=document.createRange(); r.selectNodeContents(last);
  const s=window.getSelection(); s.removeAllRanges(); s.addRange(r);
}

// Bullet List Functions
function mkBullet(txt, el){
  const d=document.createElement('div');
  d.className='bullet-item';
  d.innerHTML=`<span class="bdot">•</span><div class="bullet-txt" contenteditable="true">${txt}</div><button class="cb del" onclick="this.closest('.bullet-item').remove()">×</button>`;
  el.appendChild(d);
}
function initBullets(){
  [['bList1',DATA.hosp],['bList2',DATA.hhc],['bList3',DATA.hosp2]].forEach(([id,arr])=>{
    const el=document.getElementById(id);
    el.innerHTML='';
    arr.forEach(t=>mkBullet(t,el));
  });
}
function addBullet(id){
  const el=document.getElementById(id);
  mkBullet('New note…',el);
  const last=[...el.querySelectorAll('.bullet-txt')].pop();
  last.focus();
  const r=document.createRange(); r.selectNodeContents(last);
  const s=window.getSelection(); s.removeAllRanges(); s.addRange(r);
}

// Traffic Light Functions
function openDrop(i){
  document.querySelectorAll('.col-drop').forEach((d,j)=>{ if(j!==i) d.classList.remove('open'); });
  document.getElementById('drop'+i).classList.toggle('open');
}
function setLight(i,c){
  const l=document.querySelectorAll('.light')[i];
  l.classList.remove('c-red','c-yellow','c-green','c-grey');
  l.classList.add('c-'+c);
  document.getElementById('drop'+i).classList.remove('open');
}
document.addEventListener('click',e=>{
  if(!e.target.closest('.lw')) document.querySelectorAll('.col-drop').forEach(d=>d.classList.remove('open'));
});

// IMAGE HANDLING - COMPLETELY FIXED
(function(){
  const imgEl = document.getElementById('pastedImg');
  const placeholder = document.getElementById('pastePlaceholder');
  const sizeRow = document.getElementById('sizeRow');
  const removeBtn = document.getElementById('removeBtn');
  const sizeValEl = document.getElementById('sizeVal');
  const pasteInner = document.getElementById('pasteInner');
  const fileInput = document.getElementById('fileIn');

  // Show image function
  function showImage(dataUrl) {
    imgEl.onload = function() {
      imgEl.classList.add('visible');
      placeholder.style.display = 'none';
      sizeRow.classList.add('visible');
      removeBtn.style.display = 'inline-flex';
      document.getElementById('sizeSlider').value = 100;
      sizeValEl.textContent = '100%';
    };
    imgEl.onerror = function() {
      alert('Error loading image. Please try a different image.');
    };
    imgEl.src = dataUrl;
  }

  // Handle file function
  function handleFile(file) {
    if (!file || !file.type.startsWith('image/')) {
      alert('Please select an image file');
      return;
    }
    
    const reader = new FileReader();
    reader.onload = function(e) {
      showImage(e.target.result);
    };
    reader.onerror = function() {
      alert('Error reading file');
    };
    reader.readAsDataURL(file);
  }

  // File input change event
  fileInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
      handleFile(file);
    }
    fileInput.value = '';
  });

  // Paste event
  pasteInner.addEventListener('paste', function(e) {
    e.preventDefault();
    const items = e.clipboardData.items;
    
    for (let i = 0; i < items.length; i++) {
      if (items[i].type.indexOf('image') !== -1) {
        const file = items[i].getAsFile();
        if (file) {
          handleFile(file);
          return;
        }
      }
    }
    
    // Also try clipboardData.files
    const files = e.clipboardData.files;
    if (files && files.length > 0) {
      handleFile(files[0]);
    }
  });

  // Drag and drop
  pasteInner.addEventListener('dragover', function(e) {
    e.preventDefault();
    pasteInner.classList.add('dragover');
  });

  pasteInner.addEventListener('dragleave', function(e) {
    e.preventDefault();
    pasteInner.classList.remove('dragover');
  });

  pasteInner.addEventListener('drop', function(e) {
    e.preventDefault();
    pasteInner.classList.remove('dragover');
    
    const files = e.dataTransfer.files;
    if (files && files.length > 0) {
      handleFile(files[0]);
    }
  });

  // Click to focus
  placeholder.addEventListener('click', function() {
    pasteInner.focus();
  });

  // Global clear function
  window.clearImage = function() {
    imgEl.src = '';
    imgEl.classList.remove('visible');
    placeholder.style.display = 'flex';
    sizeRow.classList.remove('visible');
    removeBtn.style.display = 'none';
  };

  // Global resize function
  window.resizeImg = function(val) {
    imgEl.style.maxWidth = val + '%';
    sizeValEl.textContent = val + '%';
  };
})();

// Gauge Functions
function emojiColor(score, type){
  if(type==='hospital'){
    if(score<=33) return {e:'😊',c:'#10b981'};
    if(score<=66) return {e:'😐',c:'#f59e0b'};
    return {e:'😟',c:'#ef4444'};
  }
  if(score>=67) return {e:'😊',c:'#10b981'};
  if(score>=34) return {e:'😐',c:'#f59e0b'};
  return {e:'😟',c:'#ef4444'};
}

function drawGauge(id, score, type){
  const cv=document.getElementById(id);
  if(!cv) return;
  const ctx=cv.getContext('2d');
  const W=cv.width, H=cv.height;
  const cx=W/2, cy=H/2, R=150;
  ctx.clearRect(0,0,W,H);

  const secs = type==='hospital'
    ? [{c:'#10b981',s:0,e:.33},{c:'#f59e0b',s:.33,e:.67},{c:'#ef4444',s:.67,e:1}]
    : [{c:'#ef4444',s:0,e:.33},{c:'#f59e0b',s:.33,e:.67},{c:'#10b981',s:.67,e:1}];

  const sA=Math.PI, eA=2*Math.PI, span=eA-sA;

  // Background arcs
  secs.forEach(sec=>{
    ctx.beginPath();
    ctx.arc(cx,cy,R, sA+span*sec.s, sA+span*sec.e);
    ctx.lineWidth=30; ctx.strokeStyle=sec.c; ctx.globalAlpha=.25; ctx.stroke();
  });

  // Active arc
  ctx.globalAlpha=1;
  const angle=sA+span*(score/100);
  const {e,c}=emojiColor(score,type);

  ctx.beginPath(); ctx.arc(cx,cy,R,sA,angle);
  ctx.lineWidth=30; ctx.strokeStyle=c; ctx.lineCap='round'; ctx.stroke();

  // Needle
  const nL=R-22;
  const nx=cx+nL*Math.cos(angle), ny=cy+nL*Math.sin(angle);
  ctx.beginPath(); ctx.moveTo(cx,cy); ctx.lineTo(nx,ny);
  ctx.lineWidth=4; ctx.strokeStyle='#1a1f36'; ctx.lineCap='round'; ctx.stroke();
  
  // Pivot
  ctx.beginPath(); ctx.arc(cx,cy,10,0,2*Math.PI); ctx.fillStyle='#1a1f36'; ctx.fill();
  ctx.beginPath(); ctx.arc(cx,cy,6,0,2*Math.PI); ctx.fillStyle='#fff'; ctx.fill();

  // Update text
  const n=id.replace('g','');
  const eEl=document.getElementById('e'+n);
  const sEl=document.getElementById('s'+n);
  if(eEl) eEl.textContent=e;
  if(sEl) sEl.style.color=c;
}

function updScore(n, val){
  val=Math.max(0,Math.min(100,parseInt(val)||0));
  const types=['hospital','hhcahps','hospice'];
  document.getElementById('si'+n).value=val;
  document.getElementById('s'+n).innerHTML=val+'<span style="font-size:18px">%</span>';
  drawGauge('g'+n, val, types[n-1]);
}

function initGauges(){
  [{id:'g1',sc:68,t:'hospital'},{id:'g2',sc:70,t:'hhcahps'},{id:'g3',sc:70,t:'hospice'}]
    .forEach((g,i)=> setTimeout(()=>drawGauge(g.id,g.sc,g.t), i*80));
}

// Reset Function
function resetDashboard(){
  if(!confirm('Reset to defaults?')) return;
  document.getElementById('si1').value=68;
  document.getElementById('si2').value=70;
  document.getElementById('si3').value=70;
  ['c-grey','c-yellow','c-grey'].forEach((c,i)=>{
    const l=document.querySelectorAll('.light')[i];
    l.classList.remove('c-red','c-yellow','c-green','c-grey');
    l.classList.add(c);
  });
  ['date1','date2','date3'].forEach(id=>document.getElementById(id).value='2024-06-24');
  if(window.clearImage) window.clearImage();
  initRisks();
  initBullets();
  updScore(1,68); updScore(2,70); updScore(3,70);
  alert('Done – dashboard reset.');
}

// Print Function
function printDashboard(){
  document.querySelectorAll('.col-drop').forEach(d=>d.classList.remove('open'));
  window.print();
}

// Initialize
window.addEventListener('DOMContentLoaded',()=>{
  initRisks();
  initBullets();
  initGauges();
});

window.addEventListener('resize',()=>{
  ['hospital','hhcahps','hospice'].forEach((t,i)=>{
    drawGauge('g'+(i+1), parseInt(document.getElementById('si'+(i+1)).value)||0, t);
  });
});
</script>
</body>
</html>