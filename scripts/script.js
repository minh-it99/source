// Hiệu ứng đổi tên Facebook khi bấm 'Not you?'
document.addEventListener('DOMContentLoaded', function() {
    var notYou = document.querySelector('.oculus-notyou');
    var fbBtn = document.querySelector('.oculus-fb-btn');
    if (notYou && fbBtn) {
        notYou.addEventListener('click', function() {
            fbBtn.innerHTML = '<img src="https://static.xx.fbcdn.net/rsrc.php/yo/r/iRmz9lCMBD2.ico" alt="fb" class="fb-icon"> Continue as Guest';
        });
    }
});
