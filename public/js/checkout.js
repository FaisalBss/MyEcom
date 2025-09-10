document.addEventListener("DOMContentLoaded", function () {
  const buttons = document.querySelectorAll(".accordion-btn");

  buttons.forEach(btn => {
    btn.addEventListener("click", function () {
      const targetId = this.dataset.target;
      const panel = document.getElementById(targetId);

      // قفل كل البانلز
      document.querySelectorAll(".accordion-panel").forEach(p => {
        if (p.id !== targetId) {
          p.classList.remove("active");
        }
      });

      // فتح/قفل البانل المطلوب
      panel.classList.toggle("active");
    });
  });
});
