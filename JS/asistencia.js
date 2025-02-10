document.addEventListener('DOMContentLoaded', () => {
  const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
  const daysContainer = document.querySelector('.days');
  const monthYear = document.getElementById('monthYear');
  const prevButton = document.getElementById('prev');
  const nextButton = document.getElementById('next');
  const shiftDetailsElement = document.getElementById('shiftDetails');

  let date = new Date();
  let currentMonth = date.getMonth();
  let currentYear = date.getFullYear();

  function renderCalendar(month, year) {
      daysContainer.innerHTML = '';
      monthYear.textContent = `${monthNames[month]} ${year}`;

      const firstDay = new Date(year, month, 1).getDay();
      const daysInMonth = new Date(year, month + 1, 0).getDate();

      // Ajustar el primer día de la semana a Domingo
      const adjustedFirstDay = (firstDay + 6) % 7;

      for (let i = 0; i < adjustedFirstDay; i++) {
          daysContainer.innerHTML += `<div></div>`; // Espacios vacíos para los días previos
      }

      for (let i = 1; i <= daysInMonth; i++) {
          const formattedDate = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;

          // Usamos formularios invisibles, pero mantenemos el diseño visual con divs
          daysContainer.innerHTML += `
              <div class="day" style="display:inline-block;">
                  <form method="post" style="display:inline;">
                      <input type="hidden" name="fecha" value="${formattedDate}">
                      <button type="submit" style="background:none;border:none;padding:0;margin:0;color:inherit;cursor:pointer;">
                          ${i}
                      </button>
                  </form>
              </div>`;
      }
  }

  // Renderizar el calendario inicialmente
  renderCalendar(currentMonth, currentYear);

  // Navegar al mes anterior
  prevButton.addEventListener('click', () => {
      currentMonth--;
      if (currentMonth < 0) {
          currentMonth = 11;
          currentYear--;
      }
      renderCalendar(currentMonth, currentYear);
  });

  // Navegar al próximo mes
  nextButton.addEventListener('click', () => {
      currentMonth++;
      if (currentMonth > 11) {
          currentMonth = 0;
          currentYear++;
      }
      renderCalendar(currentMonth, currentYear);
  });
});
