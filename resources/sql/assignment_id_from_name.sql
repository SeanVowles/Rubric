SELECT user_assignment_grade.assignment_id, assignment.assignment_name
FROM assignment
    LEFT JOIN user_assignment_grade ON user_assignment_grade.assignment_id = assignment.assignment_id
WHERE (assignment.assignment_name = "JavaScript")
