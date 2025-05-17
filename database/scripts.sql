SELECT 
    e.name AS curso,
    COUNT(DISTINCT i.user_id) AS total_inscritos,
    COUNT(DISTINCT CASE WHEN f.is_present = 1 THEN f.user_id END) AS total_presentes,
    COUNT(DISTINCT CASE WHEN f.is_present = 1 AND f.justification IS NOT NULL THEN f.user_id END) AS total_online,
    COUNT(DISTINCT CASE WHEN f.is_present = 0 OR f.id IS NULL THEN i.user_id END) AS total_faltas,
    COUNT(DISTINCT CASE WHEN f.is_present = 0 AND f.is_justified = 1 THEN f.user_id END) AS total_faltas_justificadas,
    COUNT(DISTINCT r.user_id) AS total_responderam_atividades,
    COUNT(DISTINCT CASE 
        WHEN (
            SELECT COUNT(*) 
            FROM responses r2 
            JOIN questions q ON r2.question_id = q.id
            JOIN activities a ON q.activity_id = a.id
            WHERE r2.user_id = r.user_id 
            AND r2.status = 'correto'
            AND a.lesson_id IN (634, 695)
        ) / 5.0 < 0.5 THEN r.user_id 
    END) AS total_aproveitamento_inferior_50,
    COUNT(DISTINCT CASE 
        WHEN (
            SELECT COUNT(*) 
            FROM responses r2 
            JOIN questions q ON r2.question_id = q.id
            JOIN activities a ON q.activity_id = a.id
            WHERE r2.user_id = r.user_id 
            AND r2.status = 'correto'
            AND a.lesson_id IN (634, 695)
        ) / 5.0 BETWEEN 0.5 AND 0.8 THEN r.user_id 
    END) AS total_aproveitamento_entre_50_e_80,
    COUNT(DISTINCT CASE 
        WHEN (
            SELECT COUNT(*) 
            FROM responses r2 
            JOIN questions q ON r2.question_id = q.id
            JOIN activities a ON q.activity_id = a.id
            WHERE r2.user_id = r.user_id 
            AND r2.status = 'correto'
            AND a.lesson_id IN (634, 695)
        ) / 5.0 > 0.8 THEN r.user_id 
    END) AS total_aproveitamento_acima_80
FROM 
    events e
JOIN 
    inscriptions i ON e.id = i.event_id
LEFT JOIN 
    frequencies f ON i.user_id = f.user_id AND i.event_id = f.event_id AND f.lesson_id IN (634, 695)
LEFT JOIN 
    responses r ON i.user_id = r.user_id
    AND r.question_id IN (
        SELECT q.id 
        FROM questions q
        JOIN activities a ON q.activity_id = a.id
        WHERE a.lesson_id IN (634, 695)
    )
WHERE 
    e.id IN (61, 58) AND i.status = 'L'
GROUP BY 
    e.name;

-- 634 / 695 

-- lista de lideres com pendencias
SELECT DISTINCT
    u.name AS nome,
    CONCAT(
        CASE 
            WHEN f1.is_present = 1 AND f1.justification IS NULL THEN 'Presente; '
            WHEN f1.is_present = 1 AND f1.justification IS NOT NULL THEN 'Online; '
            WHEN f1.is_present = 0 AND f1.is_justified = 1 THEN 'Falta Justificada; '
            WHEN (f1.is_present = 0 AND f1.is_justified = 0) OR f1.id IS NULL THEN 'Faltou; '
            ELSE ''
        END,
        CASE 
            WHEN r1.user_id IS NOT NULL AND (
                SELECT COUNT(*) 
                FROM responses r2 
                JOIN questions q ON r2.question_id = q.id
                JOIN activities a ON q.activity_id = a.id
                WHERE r2.user_id = r1.user_id 
                AND r2.status = 'correto'
                AND a.lesson_id = 633
            ) / 5.0 < 0.5 THEN 'Aproveitamento Inferior a 50%; '
            ELSE ''
        END,
        CASE 
            WHEN r1.user_id IS NULL AND f1.id IS NOT NULL THEN 'Não Respondeu a Atividade; '
            ELSE ''
        END
    ) AS aula_633,
    CONCAT(
        CASE 
            WHEN f2.is_present = 1 AND f2.justification IS NULL THEN 'Presente; '
            WHEN f2.is_present = 1 AND f2.justification IS NOT NULL THEN 'Online; '
            WHEN f2.is_present = 0 AND f2.is_justified = 1 THEN 'Falta Justificada; '
            WHEN (f2.is_present = 0 AND f2.is_justified = 0) OR f2.id IS NULL THEN 'Faltou; '
            ELSE ''
        END,
        CASE 
            WHEN r2.user_id IS NOT NULL AND (
                SELECT COUNT(*) 
                FROM responses r3
                JOIN questions q ON r3.question_id = q.id
                JOIN activities a ON q.activity_id = a.id
                WHERE r3.user_id = r2.user_id 
                AND r3.status = 'correto'
                AND a.lesson_id = 695
            ) / 5.0 < 0.5 THEN 'Aproveitamento Inferior a 50%; '
            ELSE ''
        END,
        CASE 
            WHEN r2.user_id IS NULL AND f2.id IS NOT NULL THEN 'Não Respondeu a Atividade; '
            ELSE ''
        END
    ) AS aula_695
FROM 
    inscriptions i
JOIN 
    users u ON i.user_id = u.id
LEFT JOIN 
    profiles p ON u.id = p.user_id
LEFT JOIN 
    frequencies f1 ON i.user_id = f1.user_id AND i.event_id = f1.event_id AND f1.lesson_id = 633
LEFT JOIN 
    frequencies f2 ON i.user_id = f2.user_id AND i.event_id = f2.event_id AND f2.lesson_id = 695
LEFT JOIN 
    responses r1 ON i.user_id = r1.user_id
    AND r1.question_id IN (
        SELECT q.id 
        FROM questions q
        JOIN activities a ON q.activity_id = a.id
        WHERE a.lesson_id = 633
    )
LEFT JOIN 
    responses r2 ON i.user_id = r2.user_id
    AND r2.question_id IN (
        SELECT q.id 
        FROM questions q
        JOIN activities a ON q.activity_id = a.id
        WHERE a.lesson_id = 695
    )
WHERE 
    i.event_id = 61 AND i.status = 'L'
    AND (
        -- Pendências na aula 633
        f1.is_present = 0 OR 
        f1.justification IS NOT NULL OR
        (r1.user_id IS NULL AND f1.id IS NOT NULL) OR
        (
            r1.user_id IS NOT NULL AND (
                SELECT COUNT(*) 
                FROM responses r2 
                JOIN questions q ON r2.question_id = q.id
                JOIN activities a ON q.activity_id = a.id
                WHERE r2.user_id = r1.user_id 
                AND r2.status = 'correto'
                AND a.lesson_id = 633
            ) / 5.0 < 0.5
        ) OR
        
        -- Pendências na aula 695
        f2.is_present = 0 OR 
        f2.justification IS NOT NULL OR
        (r2.user_id IS NULL AND f2.id IS NOT NULL) OR
        (
            r2.user_id IS NOT NULL AND (
                SELECT COUNT(*) 
                FROM responses r3
                JOIN questions q ON r3.question_id = q.id
                JOIN activities a ON q.activity_id = a.id
                WHERE r3.user_id = r2.user_id 
                AND r3.status = 'correto'
                AND a.lesson_id = 695
            ) / 5.0 < 0.5
        )
    )
ORDER BY u.name ASC;



SELECT 
    COUNT(DISTINCT CASE WHEN f.is_present = 1 THEN f.user_id END) AS total_presentes,
    COUNT(DISTINCT CASE WHEN f.is_present = 0 OR f.id IS NULL THEN f.user_id END) AS total_faltas,
    COUNT(DISTINCT CASE WHEN f.is_present = 1 AND f.justification IS NOT NULL THEN f.user_id END) AS total_online,
    COUNT(DISTINCT CASE WHEN f.is_present = 0 AND f.is_justified = 1 THEN f.user_id END) AS total_faltas_justificadas
FROM 
    inscriptions i
LEFT JOIN 
    frequencies f ON i.user_id = f.user_id AND i.event_id = f.event_id
WHERE 
    i.event_id = 58 AND i.status = 'L';