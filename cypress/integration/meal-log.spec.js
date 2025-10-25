describe('Meal Log Page', () => {
  it('should load and display meal log table', () => {
    cy.visit('/public/meal-log.html');
    cy.get('#mealTable').should('exist');
  });
  it('should add a new meal', () => {
    cy.visit('/public/meal-log.html');
    cy.get('#mealName').type('Cypress Test Meal');
    cy.get('#calories').type('600');
    cy.get('#addMealForm').submit();
    // You may want to check for a success message or table update
  });
});
