// Mostrar mensaje al hacer clic en el botón
document.getElementById('cta-btn').addEventListener('click', () => {
    alert('Gracias por tu interés. Serás redirigido al formulario de inscripción.');
     window.location.href = 'formulario.html';
  });
  
  // Scroll reveal
  const sections = document.querySelectorAll('section');
  
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach(entry => {
        if(entry.isIntersecting){
          entry.target.classList.add('visible');
        }
      });
    },
    { threshold: 0.2 }
  );
  
  sections.forEach(section => {
    section.classList.add('hidden');
    observer.observe(section);
  });
  