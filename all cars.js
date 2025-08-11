document.addEventListener('DOMContentLoaded', function() {
  const companyFilter = document.getElementById('company-filter');
  const costFilter = document.getElementById('cost-filter');
  const carCards = document.querySelectorAll('.car-card');

  function filterCars() {
    const companyValue = companyFilter.value;
    const costValue = costFilter.value;

    carCards.forEach(card => {
      const carCompany = card.getAttribute('data-company');
      const carCost = parseInt(card.getAttribute('data-cost'));
      // Company filter
      let showByCompany = (companyValue === 'all' || carCompany === companyValue);
      // Cost filter
      let showByCost = false;
      if (costValue === 'all') showByCost = true;
      else if (costValue === 'low') showByCost = carCost < 2500;
      else if (costValue === 'mid') showByCost = (carCost >= 2500 && carCost <= 3500);
      else if (costValue === 'high') showByCost = carCost > 3500;

      if (showByCompany && showByCost) {
        card.style.display = "";
      } else {
        card.style.display = "none";
      }
    });
  }

  companyFilter.addEventListener('change', filterCars);
  costFilter.addEventListener('change', filterCars);

  // Apply filter on page load
  filterCars();
});