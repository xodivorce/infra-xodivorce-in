document.addEventListener('DOMContentLoaded', function() {
  var countdownElem = document.getElementById('countdown');
  const submitBtn = document.getElementById('submitBtn');

  if (countdownElem && submitBtn) {
    var remaining = parseInt(countdownElem.textContent);

    function updateText(sec) {
      if (sec > 0) {
        countdownElem.textContent = "Please wait " + sec + " seconds before requesting again.";
        countdownElem.className = '';
        submitBtn.disabled = true;
      } else {
        countdownElem.textContent = "You can now try requesting the email again.";
        countdownElem.className = 'text-green-400 text-sm';
        submitBtn.disabled = false;
      }
    }

    updateText(remaining);

    const interval = setInterval(() => {
      remaining--;
      updateText(remaining);

      if (remaining <= 0) clearInterval(interval);
    }, 1000);
  }
});