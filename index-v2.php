<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>RPM Clinical Analysis Dashboard</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }

body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Arial, sans-serif;
    background:#f8f9fa;
    color:#1a1f36;
    line-height:1.5;
}

.controls-bar {
    background:linear-gradient(135deg,#667eea,#764ba2);
    padding:10px 24px;
    display:flex; gap:12px;
    justify-content:flex-end;
}
.btn {
    padding:9px 18px; border:none; border-radius:6px;
    font-weight:600; font-size:13px; cursor:pointer;
    transition:all .2s;
}
.btn-reset { background:#ef4444; color:#fff; }
.btn-print { background:#fff; color:#667eea; }

.header {
    background:linear-gradient(135deg,#1a1f36,#2d3748);
    color:#fff; padding:14px 28px;
}
.header h1 { font-size:18px; font-weight:700; }
.header p  { font-size:11px; opacity:.85; }

.main-layout {
    display:grid;
    grid-template-columns:30% 70%;
    background:#fff;
}

.left-column {
    background:#fafbfc;
    border-right:2px solid #e0e5eb;
    padding:16px;
    display:flex; flex-direction:column; gap:14px;
}

.right-column {
    padding:16px 20px;
    display:flex; flex-direction:column; gap:16px;
}

.tl-wrap {
    background:#2d3748;
    padding:14px;
    border-radius:22px;
    margin:0 auto;
}
.tl { display:flex; gap:14px; }
.light {
    width:48px; height:48px; border-radius:50%;
    box-shadow:inset 0 2px 8px rgba(0,0,0,.3);
}
.light.c-grey { background:#6b7280; }
.light.c-yellow { background:#f59e0b; box-shadow:0 0 22px rgba(245,158,11,.6); }

.section-hd {
    font-size:13px; font-weight:700;
    margin-bottom:8px;
}
.risk-list {
    background:#fff;
    border-radius:8px;
    padding:10px;
    border:1px solid #e0e5eb;
}
.risk-item {
    display:flex; gap:5px;
    margin-bottom:7px;
    font-size:11.5px;
    line-height:1.45;
}
.risk-num {
    flex-shrink:0;
    font-weight:700;
    color:#ef4444;
}
.risk-txt {
    flex:1;
}

/* IMAGE UPLOAD BOX */
.img-upload-box {
    border:2px dashed #e0e5eb;
    border-radius:10px;
    background:#fff;
    padding:16px;
    text-align:center;
}

.upload-form {
    margin-bottom:12px;
}

.file-input-wrapper {
    position:relative;
    display:inline-block;
}

.upload-label {
    padding:10px 16px;
    background:#667eea;
    color:#fff;
    border-radius:6px;
    font-size:12px;
    font-weight:600;
    cursor:pointer;
    display:inline-block;
}

.file-input-wrapper input[type=file] {
    position:absolute;
    left:0; top:0;
    width:100%;
    height:100%;
    opacity:0;
    cursor:pointer;
}

.upload-btn {
    padding:8px 14px;
    background:#10b981;
    color:#fff;
    border:none;
    border-radius:6px;
    font-size:12px;
    font-weight:600;
    cursor:pointer;
    margin-left:8px;
}

.uploaded-img {
    max-width:100%;
    max-height:200px;
    border-radius:6px;
    margin-top:10px;
}

.no-image {
    color:#697386;
    font-size:12px;
    padding:20px;
}

.metric-row {
    display:grid;
    grid-template-columns:75% 25%;
    gap:20px;
    padding-bottom:16px;
    border-bottom:2px solid #e0e5eb;
}
.metric-row:last-child { border-bottom:none; }

.metric-header {
    display:flex;
    justify-content:space-between;
    margin-bottom:8px;
}
.date-inp {
    background:#1a1f36;
    color:#fff;
    padding:5px 10px;
    border:none;
    border-radius:6px;
    font-size:10px;
    font-weight:600;
}
.m-title {
    font-size:20px;
    font-weight:800;
    text-transform:uppercase;
}
.m-title.hospital { color:#ef4444; }
.m-title.hhcahps { color:#0891b2; }
.m-title.hospice { color:#f97316; }

.bullet-list {
    background:#fafbfc;
    border:1px solid #e0e5eb;
    border-radius:8px;
    padding:12px;
}
.bullet-item {
    font-size:11.5px;
    line-height:1.5;
    margin-bottom:7px;
}

.gauge-col {
    display:flex;
    flex-direction:column;
    gap:8px;
    align-items:center;
}
.gauge-wrap {
    position:relative;
    width:180px;
    height:180px;
}
canvas {
    width:100%;
    height:100%;
}
.gauge-over {
    position:absolute;
    top:44%;
    left:50%;
    transform:translate(-50%,-50%);
    text-align:center;
}
.g-emoji {
    font-size:32px;
    display:block;
}
.g-score {
    font-size:24px;
    font-weight:800;
}
.g-label {
    font-size:9px;
    font-weight:600;
    color:#697386;
    text-transform:uppercase;
}
.score-inp {
    width:180px;
    padding:7px;
    border:2px solid #e0e5eb;
    border-radius:6px;
    font-weight:700;
    font-size:15px;
    text-align:center;
}
.g-legend {
    display:flex;
    gap:6px;
    width:180px;
    justify-content:space-between;
    flex-wrap:wrap;
}
.g-leg-item {
    display:flex;
    align-items:center;
    gap:3px;
    font-size:7.5px;
    font-weight:600;
}
.g-leg-clr {
    width:9px;
    height:9px;
    border-radius:2px;
}

@media print {
    .controls-bar, .upload-form, .score-inp { 
        display:none !important; 
    }
}
</style>
</head>
<body>

<?php
$uploadedImage = '';

if (!empty($_FILES['graph']['name'])) {
    $dir = __DIR__ . '/uploads/';
    if (!is_dir($dir)) mkdir($dir, 0755, true);

    $name = time() . '_' . basename($_FILES['graph']['name']);
    $path = $dir . $name;

    if (move_uploaded_file($_FILES['graph']['tmp_name'], $path)) {
        $uploadedImage = 'uploads/' . $name;
    }
}
?>

<div class="controls-bar">
    <button class="btn btn-reset" onclick="window.location.reload()">🔄 Reset</button>
    <button class="btn btn-print" onclick="window.print()">🖨️ Print</button>
</div>

<div class="header">
    <h1>🏥 Remote Patient Monitoring – Clinical Analysis Dashboard</h1>
    <p>Comprehensive risk assessment and care coordination metrics | Generated by Clinical Care Team</p>
</div>

<div class="main-layout">

<!-- LEFT COLUMN -->
<div class="left-column">

    <div class="tl-wrap">
        <div class="tl">
            <div class="light c-grey"></div>
            <div class="light c-yellow"></div>
            <div class="light c-grey"></div>
        </div>
    </div>

    <div>
        <div class="section-hd">High Risk Factors</div>
        <div class="risk-list">
            <div class="risk-item"><div class="risk-num">1.</div><div class="risk-txt">Indwelling Foley catheter with leaking and discomfort complications</div></div>
            <div class="risk-item"><div class="risk-num">2.</div><div class="risk-txt">UTI risk 35-40% from catheter since 12/10/25</div></div>
            <div class="risk-item"><div class="risk-num">3.</div><div class="risk-txt">Untreated Stage 1-2 HTN: BP 144-151/71 mmHg</div></div>
            <div class="risk-item"><div class="risk-num">4.</div><div class="risk-txt">Zero antihypertensive medications despite age 79 and HTN</div></div>
            <div class="risk-item"><div class="risk-num">5.</div><div class="risk-txt">History of falling without documented fall assessment</div></div>
            <div class="risk-item"><div class="risk-num">6.</div><div class="risk-txt">Voiding trial scheduled 12/19/25 with 20-25% failure risk</div></div>
            <div class="risk-item"><div class="risk-num">7.</div><div class="risk-txt">Incomplete medication list: only 2 medications documented</div></div>
            <div class="risk-item"><div class="risk-num">8.</div><div class="risk-txt">Headaches potentially indicating uncontrolled hypertension symptoms</div></div>
            <div class="risk-item"><div class="risk-num">9.</div><div class="risk-txt">Walker dependent with taxing effort limiting mobility</div></div>
            <div class="risk-item"><div class="risk-num">10.</div><div class="risk-txt">Age 79 with stroke/MI risk 12-18% annually</div></div>
            <div class="risk-item"><div class="risk-num">11.</div><div class="risk-txt">No orthostatic BP measurements despite fall history</div></div>
            <div class="risk-item"><div class="risk-num">12.</div><div class="risk-txt">Tylenol 1000mg single dose exceeds recommended 650mg</div></div>
        </div>
    </div>

    <!-- IMAGE UPLOAD -->
    <div class="img-upload-box">
        <form method="post" enctype="multipart/form-data" class="upload-form">
            <div class="file-input-wrapper">
                <label class="upload-label">
                    📂 Choose Graph
                    <input type="file" name="graph" accept="image/*" onchange="this.form.submit()">
                </label>
            </div>
        </form>

        <?php if (!empty($uploadedImage)): ?>
            <img src="<?= htmlspecialchars($uploadedImage) ?>" class="uploaded-img" alt="Trend graph">
        <?php else: ?>
            <div class="no-image">No graph uploaded yet</div>
        <?php endif; ?>
    </div>

</div>

<!-- RIGHT COLUMN -->
<div class="right-column">

    <!-- ROW 1 -->
    <div class="metric-row">
        <div>
            <div class="metric-header">
                <input type="date" class="date-inp" value="2024-06-24">
                <div class="m-title hospital">HOSPITAL RISK</div>
            </div>
            <div class="bullet-list">
                <div class="bullet-item">• David's Blood Pressure monitoring is critically absent with no BP readings documented despite HTN diagnosis and hydrochlorothiazide 12.5mg with hold parameter "if SBP &lt;110"; cannot assess control or hypotension risk</div>
                <div class="bullet-item">• David has engaged with care team through skilled nursing visits for complex wound care, colostomy management, and suprapubic catheter care at board and care facility</div>
                <div class="bullet-item">• David had 0 BP measurements documented despite HTN diagnosis requiring urgent monitoring establishment</div>
                <div class="bullet-item">• David has board and care facility caregivers providing 24-hour supervision and assistance as documented in clinical notes</div>
            </div>
        </div>
        <div class="gauge-col">
            <input type="number" class="score-inp" value="68" min="0" max="100" onchange="draw(1,this.value)">
            <div class="gauge-wrap">
                <canvas id="g1" width="400" height="400"></canvas>
                <div class="gauge-over">
                    <span class="g-emoji" id="e1">😟</span>
                    <div class="g-score" id="s1" style="color:#ef4444">68%</div>
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

    <!-- ROW 2 -->
    <div class="metric-row">
        <div>
            <div class="metric-header">
                <input type="date" class="date-inp" value="2024-06-24">
                <div class="m-title hhcahps">HHCAHPS</div>
            </div>
            <div class="bullet-list">
                <div class="bullet-item">• Katherine has routine contact with care team through scheduled skilled nursing (SN) and physical therapy (PT) visits</div>
                <div class="bullet-item">• Katherine has NOT initiated contact on her own via SMS or phone (no documentation of patient-initiated contact)</div>
                <div class="bullet-item">• Katherine's care team includes: Ana Moreno-Quirarte RN (medication review, assessment), Lindsay PTA (physical therapy visits), and physician oversight</div>
            </div>
        </div>
        <div class="gauge-col">
            <input type="number" class="score-inp" value="70" min="0" max="100" onchange="draw(2,this.value)">
            <div class="gauge-wrap">
                <canvas id="g2" width="400" height="400"></canvas>
                <div class="gauge-over">
                    <span class="g-emoji" id="e2">😊</span>
                    <div class="g-score" id="s2" style="color:#10b981">70%</div>
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

    <!-- ROW 3 -->
    <div class="metric-row">
        <div>
            <div class="metric-header">
                <input type="date" class="date-inp" value="2024-06-24">
                <div class="m-title hospice">HOSPICE NEED</div>
            </div>
            <div class="bullet-list">
                <div class="bullet-item">• Katherine has NOT had a kidney transplant (no transplant history documented)</div>
                <div class="bullet-item">• Katherine's weight: Not documented in available records (weight monitoring needed)</div>
                <div class="bullet-item">• Katherine reports: "Lots of pain" documented in clinical notes; exhaustion documented as risk factor; pain management with ice/medication education provided</div>
            </div>
        </div>
        <div class="gauge-col">
            <input type="number" class="score-inp" value="70" min="0" max="100" onchange="draw(3,this.value)">
            <div class="gauge-wrap">
                <canvas id="g3" width="400" height="400"></canvas>
                <div class="gauge-over">
                    <span class="g-emoji" id="e3">😊</span>
                    <div class="g-score" id="s3" style="color:#10b981">70%</div>
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

</div>
</div>

<script>
// GAUGE DRAW FUNCTION
function draw(n, v) {
    v = Math.max(0, Math.min(100, parseInt(v)));
    var t = n===1 ? 'h' : 'o';
    var c = document.getElementById('g'+n);
    var x = c.getContext('2d');
    var w = c.width, h = c.height;
    var cx = w/2, cy = h/2, r = 150;

    x.clearRect(0,0,w,h);

    var cols = t==='h'
        ? [{c:'#10b981',s:0,e:.33},{c:'#f59e0b',s:.33,e:.67},{c:'#ef4444',s:.67,e:1}]
        : [{c:'#ef4444',s:0,e:.33},{c:'#f59e0b',s:.33,e:.67},{c:'#10b981',s:.67,e:1}];

    var sa = Math.PI, ea = 2*Math.PI, sp = ea-sa;

    for(var i=0; i<cols.length; i++) {
        x.beginPath();
        x.arc(cx,cy,r, sa+sp*cols[i].s, sa+sp*cols[i].e);
        x.lineWidth=30;
        x.strokeStyle=cols[i].c;
        x.globalAlpha=.25;
        x.stroke();
    }

    x.globalAlpha=1;
    var ang = sa+sp*(v/100);

    var ec, col;
    if(t==='h') {
        if(v<=33){ec='😊';col='#10b981';}
        else if(v<=66){ec='😐';col='#f59e0b';}
        else{ec='😟';col='#ef4444';}
    } else {
        if(v>=67){ec='😊';col='#10b981';}
        else if(v>=34){ec='😐';col='#f59e0b';}
        else{ec='😟';col='#ef4444';}
    }

    x.beginPath();
    x.arc(cx,cy,r,sa,ang);
    x.lineWidth=30;
    x.strokeStyle=col;
    x.lineCap='round';
    x.stroke();

    var nl=r-22;
    var nx=cx+nl*Math.cos(ang), ny=cy+nl*Math.sin(ang);
    x.beginPath();
    x.moveTo(cx,cy);
    x.lineTo(nx,ny);
    x.lineWidth=4;
    x.strokeStyle='#1a1f36';
    x.lineCap='round';
    x.stroke();

    x.beginPath();
    x.arc(cx,cy,10,0,2*Math.PI);
    x.fillStyle='#1a1f36';
    x.fill();

    x.beginPath();
    x.arc(cx,cy,6,0,2*Math.PI);
    x.fillStyle='#fff';
    x.fill();

    document.getElementById('e'+n).textContent = ec;
    document.getElementById('s'+n).innerHTML = v+'%';
    document.getElementById('s'+n).style.color = col;
}

// INITIALIZE GAUGES
draw(1,68);
draw(2,70);
draw(3,70);
</script>

</body>
</html>