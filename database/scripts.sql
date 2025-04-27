SELECT 
    e.name AS curso,
    COUNT(DISTINCT i.user_id) AS total_inscritos,
    COUNT(DISTINCT CASE WHEN f.is_present = 1 THEN f.user_id END) AS total_presentes,
    COUNT(DISTINCT CASE WHEN f.is_present = 1 AND f.justification IS NOT NULL THEN f.user_id END) AS total_online,
    COUNT(DISTINCT CASE WHEN (f.is_present = 0 AND f.is_justified = 0) OR f.id IS NULL THEN i.user_id END) AS total_faltas,
    COUNT(DISTINCT CASE WHEN f.is_present = 0 AND f.is_justified = 1 THEN f.user_id END) AS total_faltas_justificadas,
    COUNT(DISTINCT r.user_id) AS total_responderam_atividades,
    COUNT(DISTINCT CASE 
        WHEN (
            SELECT COUNT(*) 
            FROM responses r2 
            WHERE r2.user_id = r.user_id 
            AND r2.status = 'correto'
        ) / 5.0 < 0.7 THEN r.user_id 
    END) AS total_aproveitamento_inferior_70,
    COUNT(DISTINCT CASE 
        WHEN (
            SELECT COUNT(*) 
            FROM responses r2 
            WHERE r2.user_id = r.user_id 
            AND r2.status = 'correto'
        ) / 5.0 BETWEEN 0.7 AND 0.9 THEN r.user_id 
    END) AS total_aproveitamento_entre_70_e_90,
    COUNT(DISTINCT CASE 
        WHEN (
            SELECT COUNT(*) 
            FROM responses r2 
            WHERE r2.user_id = r.user_id 
            AND r2.status = 'correto'
        ) / 5.0 > 0.9 THEN r.user_id 
    END) AS total_aproveitamento_acima_90
FROM 
    events e
JOIN 
    inscriptions i ON e.id = i.event_id
LEFT JOIN 
    frequencies f ON i.user_id = f.user_id AND i.event_id = f.event_id
LEFT JOIN 
    responses r ON i.user_id = r.user_id
WHERE 
    e.id IN (61, 58) AND i.status = 'L'
GROUP BY 
    e.name;


-- lista de lideres com pendencias
SELECT DISTINCT
    u.name AS nome,
    CONCAT(
        CASE 
            WHEN f.is_present = 1 AND f.justification IS NOT NULL THEN 'Online; '
            ELSE ''
        END,
        CASE 
            WHEN (f.is_present = 0 AND f.is_justified = 0) OR f.id IS NULL THEN 'Faltou; '
            ELSE ''
        END,
        CASE 
            WHEN f.is_present = 0 AND f.is_justified = 1 THEN 'Falta Justificada; '
            ELSE ''
        END,
        CASE 
            WHEN (
                SELECT COUNT(*) 
                FROM responses r2 
                WHERE r2.user_id = r.user_id 
                AND r2.status = 'correto'
            ) / 5.0 < 0.5 AND r.user_id IS NOT NULL THEN 'Aproveitamento Inferior a 50%; '
            ELSE ''
        END,
        CASE 
            WHEN r.user_id IS NULL THEN 'Não Respondeu a Atividade; '
            ELSE ''
        END
    ) AS status
FROM 
    inscriptions i
JOIN 
    users u ON i.user_id = u.id
LEFT JOIN 
    profiles p ON u.id = p.user_id
LEFT JOIN 
    frequencies f ON i.user_id = f.user_id AND i.event_id = f.event_id
LEFT JOIN 
    responses r ON i.user_id = r.user_id
WHERE 
    i.event_id = 58 AND i.status = 'L'
    AND (
        (f.is_present = 1 AND f.justification IS NOT NULL) OR
        ((f.is_present = 0 AND f.is_justified = 0) OR f.id IS NULL) OR
        (f.is_present = 0 AND f.is_justified = 1) OR
        (
            SELECT COUNT(*) 
            FROM responses r2 
            WHERE r2.user_id = r.user_id 
            AND r2.status = 'correto'
        ) / 5.0 < 0.5 AND r.user_id IS NOT NULL OR
        r.user_id IS NULL
    )  
ORDER BY u.name ASC;





SELECT DISTINCT
    u.name AS nome,
    CONCAT(
        CASE 
            WHEN f1.is_present = 1 AND f1.justification IS NOT NULL THEN CONCAT('Online; (', f1.justification, ') ')
            WHEN (f1.is_present = 0 AND f1.is_justified = 0) OR f1.id IS NULL THEN 'Faltou; '
            WHEN f1.is_present = 0 AND f1.is_justified = 1 THEN CONCAT('Falta Justificada; (', f1.justification, ') ')
            ELSE ''
        END,
        CASE 
            WHEN (
                SELECT COUNT(*) 
                FROM responses r2 
                JOIN questions q ON r2.question_id = q.id
                JOIN activities a ON q.activity_id = a.id
                WHERE r2.user_id = r1.user_id 
                AND r2.status = 'correto'
                AND a.lesson_id = 625
            ) / 5.0 < 0.5 AND r1.user_id IS NOT NULL THEN 'Aproveitamento Inferior a 50%; '
            ELSE ''
        END,
        CASE 
            WHEN r1.user_id IS NULL THEN 'Não Respondeu a Atividade; '
            ELSE ''
        END
    ) AS aula_1,
    CONCAT(
        CASE 
            WHEN f2.is_present = 1 AND f2.justification IS NOT NULL THEN CONCAT('Online; (', f2.justification, ') ')
            WHEN (f2.is_present = 0 AND f2.is_justified = 0) OR f2.id IS NULL THEN 'Faltou; '
            WHEN f2.is_present = 0 AND f2.is_justified = 1 THEN CONCAT('Falta Justificada; (', f2.justification, ') ')
            ELSE ''
        END
        -- CASE 
        --     WHEN (
        --         SELECT COUNT(*) 
        --         FROM responses r3 
        --         JOIN questions q ON r3.question_id = q.id
        --         JOIN activities a ON q.activity_id = a.id
        --         WHERE r3.user_id = r2.user_id 
        --         AND r3.status = 'correto'
        --         AND a.lesson_id = 634
        --     ) / 5.0 < 0.5 AND r2.user_id IS NOT NULL THEN 'Aproveitamento Inferior a 50%; '
        --     ELSE ''
        -- END
        -- CASE 
        --     WHEN r2.user_id IS NULL THEN 'Não Respondeu a Atividade; '
        --     ELSE ''
        -- END
    ) AS aula_2
FROM 
    inscriptions i
JOIN 
    users u ON i.user_id = u.id
LEFT JOIN 
    profiles p ON u.id = p.user_id
LEFT JOIN 
    frequencies f1 ON i.user_id = f1.user_id AND f1.lesson_id = 625
LEFT JOIN 
    frequencies f2 ON i.user_id = f2.user_id AND f2.lesson_id = 634
LEFT JOIN 
    responses r1 ON i.user_id = r1.user_id AND r1.question_id IN (
        SELECT q.id FROM questions q
        JOIN activities a ON q.activity_id = a.id
        WHERE a.lesson_id = 625
    )
LEFT JOIN 
    responses r2 ON i.user_id = r2.user_id AND r2.question_id IN (
        SELECT q.id FROM questions q
        JOIN activities a ON q.activity_id = a.id
        WHERE a.lesson_id = 634
    )
WHERE 
    i.event_id = 58 AND i.status = 'L'
ORDER BY 
    u.name ASC;



SELECT 
    COUNT(DISTINCT CASE WHEN f.is_present = 1 THEN f.user_id END) AS total_presentes,
    COUNT(DISTINCT CASE WHEN (f.is_present = 0 AND f.is_justified = 0) OR f.id IS NULL THEN f.user_id END) AS total_faltas,
    COUNT(DISTINCT CASE WHEN f.is_present = 1 AND f.justification IS NOT NULL THEN f.user_id END) AS total_online,
    COUNT(DISTINCT CASE WHEN f.is_present = 0 AND f.is_justified = 1 THEN f.user_id END) AS total_faltas_justificadas
FROM 
    inscriptions i
LEFT JOIN 
    frequencies f ON i.user_id = f.user_id AND i.event_id = f.event_id
WHERE 
    i.event_id = 58 AND i.status = 'L';