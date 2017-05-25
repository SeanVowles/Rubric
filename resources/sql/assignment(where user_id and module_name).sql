SELECT assignment.assignment_name, module.module_name, user_modules.user_id
FROM user_modules
    LEFT JOIN module ON user_modules.module_id = module.module_id
    LEFT JOIN assignment ON assignment.module_id = module.module_id
WHERE (user_modules.user_id = 2 and module.module_name = "Concurrent")
