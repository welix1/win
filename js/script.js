// 1. كود عداد الوقت التنازلي
var countDownDate = new Date("sep 29, 2026 15:37:25").getTime();

var x = setInterval(function() {
  var counter = document.querySelector("#countdown");  
  var now = new Date().getTime();
  var distance = countDownDate - now;
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
  
  if (counter) {
      counter.innerHTML = days + "يوم " + hours + "س " + minutes + "د " + seconds + "ث ";
  }
  
  if (distance < 0) {
    clearInterval(x);
    if (counter) {
        counter.innerHTML = "الوقت انتهى";
    }
  }
}, 1000);


// 2. متغيرات اللودر والسحب
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
    
    // عندما يصل العداد 100 أو أكثر
    if (al >= 100) {
        clearInterval(sim); // إيقاف العداد فوراً
        
        var loader = document.querySelector('.loader-con');
        if (loader) {
            loader.style.display = "none"; // إخفاء دائرة التحميل
        }
        
        // جلب الأسماء من القائمة المخفية
        const nameElements = document.querySelectorAll("#usersList .userName");
        const winnerDisplay = document.getElementById("winnerName");
        
        console.log("عدد الأسماء الموجودة في القائمة:", nameElements.length); // للتأكد عبر F12

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
                    winnerDisplay.textContent = "لا توجد أسماء صالحة للسحب!";
                }
            }
        } else {
            if (winnerDisplay) {
                winnerDisplay.textContent = "قائمة الأسماء فارغة في القاعدة!";
            }
        }

        // إظهار نافذة المودال بالفائز
        var modalElement = document.getElementById('modal');
        if (modalElement && typeof bootstrap !== 'undefined') {
            var myModal = new bootstrap.Modal(modalElement);
            myModal.show();
        }
        return; // الخروج من الدالة لمنع الاستمرار
    }
    
    al++;
}

// 3. الدالة التي تعمل عند الضغط على زر "اختيار الرابح"
function startWinnerDraw() {
    al = 0; // تصفير العداد ليبدأ من 0%
    var loader = document.querySelector('.loader-con');
    if (loader) {
        loader.style.display = "block"; // إظهار دائرة التحميل
    }
    clearInterval(sim); // مسح أي عداد قديم
    sim = setInterval(progressSim, 30); // تشغيل العداد بسرعة مناسبة وثابتة
}