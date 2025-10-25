describe('Workout Log Page', () => {
  it('should load and display workouts', () => {
    cy.visit('/public/workout-log.html');
    cy.get('#workoutTable').should('exist');
  });
  it('should add a new workout', () => {
    cy.visit('/public/workout-log.html');
    cy.get('#workoutName').type('Cypress Test Workout');
    cy.get('#duration').type('45');
    cy.get('#addWorkoutForm').submit();
    cy.contains('Cypress Test Workout').should('exist');
  });
});
