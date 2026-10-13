<div id="usersList" style="display: none;">
  <?php if (!empty($users)): ?>
    <?php foreach ($users as $user): ?>
      <span class="userName">
        <?php 
          $f = $user['FirstName'] ?? '';
          $l = $user['LastName'] ?? '';
          echo htmlspecialchars(trim($f . ' ' . $l)); 
        ?>
      </span>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<!-- هنا نضيف الجافاسكريبت مباشرة لضمان عدم ضياع الدالة -->
<script>
var al = 0;
var start = 4.72;
var sim;

function progressSim() {
    var canvas = document.getElementById('circularLoader');
    if (!canvas) return;
    var ctx = canvas.getContext('2d');
    var cw = canvas.width;
    var ch = canvas.height;
    
    var diff = ((al / 100) * Math.PI * 2 * 10).toFixed(2);
    ctx.clearRect(0, 0, cw, ch);
    ctx.lineWidth = 17;
    ctx.fillStyle = '#0d6efd';
    ctx.strokeStyle = "#0d6efd";
    ctx.textAlign = "center";
    ctx.font = "28px monospace";
    ctx.fillText(al + "%", cw *.52, ch *.5+5, cw+12);
    ctx.beginPath();
    ctx.arc(100, 100, 75, start, diff/10+start, false);
    ctx.stroke();
    
    if (al >= 100) {
        clearInterval(sim);
        
        var loader = document.querySelector('.loader-con');
        if (loader) {
            loader.style.display = "none";
        }
        
        const nameElements = document.querySelectorAll("#usersList .userName");
        const winnerDisplay = document.getElementById("winnerName");
        
        if (nameElements.length > 0) {
            let namesArray = [];
            nameElements.forEach(el => {
                let text = el.textContent.trim();
                if (text !== "") {
                    namesArray.push(text);
                }
            });

            if (namesArray.length > 0) {
                const randomIndex = Math.floor(Math.random() * namesArray.length);
                if (winnerDisplay) {
                    winnerDisplay.textContent = namesArray[randomIndex];
                }
            } else {
                if (winnerDisplay) {
                    winnerDisplay.textContent = "لا توجد أسماء مطابقة!";
                }
            }
        } else {
            if (winnerDisplay) {
                winnerDisplay.textContent = "قائمة الأسماء فارغة!";
            }
        }

        var modalElement = document.getElementById('modal');
        if (modalElement && typeof bootstrap !== 'undefined') {
            var myModal = new bootstrap.Modal(modalElement);
            myModal.show();
        }
    }
    al++;
}

function startWinnerDraw() {
    al = 0;
    var loader = document.querySelector('.loader-con');
    if (loader) {
        loader.style.display = "block";
    }
    clearInterval(sim);
    sim = setInterval(progressSim, 30);
}
</script>

<?php 
include './inc/db_close.php'; 
include_once './inc/parts/footer.php'; 
?>