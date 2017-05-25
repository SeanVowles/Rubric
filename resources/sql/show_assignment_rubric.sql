SELECT
  user
  assignment.assignment_name,
  user_assignment_grade.grade
FROM
  user
LEFT JOIN
  user_assignment_grade ON user_assignment_grade.user_id = user.user_id
LEFT JOIN
  assignment ON user_assignment_grade.assignment_id = assignment.assignment_id
WHERE
  (user.user_id = 2)
