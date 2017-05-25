SELECT rubric.criteria, rubric.fail, rubric.pass, rubric.merit, rubric.distinction, rubric.score
                FROM user
                LEFT JOIN user_modules
                ON user_modules.user_id = 2
                LEFT JOIN module ON user_modules.module_id = module.module_id
                LEFT JOIN assignment ON assignment.module_id = module.module_id
                LEFT JOIN rubric ON rubric.assignment_id = assignment.assignment_id
                WHERE (user.user_id = 2 AND module.module_name = "Web Applications" and assignment.assignment_name = "JavaScript")
