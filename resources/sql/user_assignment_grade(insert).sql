INSERT INTO user_assignment_grade(user_id, assignment_id)
SELECT
  user_modules.user_id,
  assignment.assignment_id
FROM USER
LEFT JOIN
  user_modules ON user_modules.user_id
LEFT JOIN
  module ON user_modules.module_id = module.module_id
LEFT JOIN
  assignment ON assignment.module_id = module.module_id
WHERE
  (USER.user_id = user_modules.user_id)
