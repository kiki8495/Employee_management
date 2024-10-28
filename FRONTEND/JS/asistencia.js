document.querySelector('.calendar').addEventListener('click', function(e) {
    if (e.target.tagName === 'DIV') {
      const selectedDay = e.target.textContent;
      // Aquí pondrías la lógica para buscar los datos de ese día
      document.getElementById('turno-info').textContent = 'Entrada: 8:00 AM, Salida: 5:00 PM';
    }
  });
  