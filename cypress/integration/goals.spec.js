describe('Goals Page', () => {
  it('should load and display goals', () => {
    cy.visit('/public/goals.html');
    cy.get('#goalsTable').should('exist');
  });
  it('should add a new goal', () => {
    cy.visit('/public/goals.html');
    cy.get('#goalText').type('Cypress Test Goal');
    cy.get('#addGoalForm').submit();
    cy.contains('Cypress Test Goal').should('exist');
  });
});
