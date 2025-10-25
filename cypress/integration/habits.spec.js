describe('Habits Page', () => {
  it('should load and display habits', () => {
    cy.visit('/public/habits.html');
    cy.get('#habitsTable').should('exist');
  });
  it('should add a new habit', () => {
    cy.visit('/public/habits.html');
    cy.get('#habitText').type('Cypress Test Habit');
    cy.get('#addHabitForm').submit();
    cy.contains('Cypress Test Habit').should('exist');
  });
});
