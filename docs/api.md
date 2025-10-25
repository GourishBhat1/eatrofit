# Eatrofit API Reference

All endpoints return JSON and require token-based authentication (where applicable).

## Endpoints

- POST `/api/register.php` — Register new user
- POST `/api/login.php` — Login and get token
- GET `/api/get_dashboard_summary.php?user_id=` — Dashboard summary
- POST `/api/add_workout_log.php` — Log workout
- GET `/api/get_workouts.php` — List workouts
- POST `/api/log_meal.php` — Log meal
- GET `/api/get_progress_report.php?user_id=` — Progress analytics
- POST `/api/add_goal.php` — Add goal
- GET `/api/get_goals.php?user_id=` — List goals
- POST `/api/add_feedback.php` — Submit feedback
- POST `/api/add_reminder.php` — Add reminder
- POST `/api/add_habit.php` — Add habit
- POST `/api/update_habit_streak.php` — Update habit streak
- GET `/api/get_habits.php?user_id=` — List habits
- GET `/api/export_progress_csv.php?user_id=` — Export progress CSV
- GET `/api/print_summary.php?user_id=` — Printable summary

## Usage
- All POST endpoints accept JSON body.
- All GET endpoints require `user_id` as query param.
- Use Authorization header for token (future enhancement).
