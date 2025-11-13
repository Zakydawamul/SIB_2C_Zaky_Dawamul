CREATE TABLE employees (
	id SERIAL PRIMARY KEY,
	first_name VARCHAR(50) NOT NULL,
	last_name VARCHAR(50) NOT NULL,
	email VARCHAR(100) UNIQUE NOT NULL,
	department VARCHAR(50),
	position VARCHAR(50),
	salary DECIMAL(10,2),
	hire_date DATE,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE projects (
	id SERIAL PRIMARY KEY,
	project_name VARCHAR(100) NOT NULL,
	department VARCHAR(50),
	budget DECIMAL(12,2),
	start_date DATE,
	end_date DATE,
	status VARCHAR(20) DEFAULT 'Active'
);

INSERT INTO employees (first_name, last_name, email, department, position, salary, hire_date) VALUES
('Ahmad', 'Hidayat', 'ahmad.hidayat@company.com', 'IT', 'Software Engineer', 8500000, '2022-01-15'),
('Siti', 'Rahayu', 'siti.rahayu@company.com', 'HR', 'HR Manager', 9500000, '2021-03-20'),
('Budi', 'Santoso', 'budi.santoso@company.com', 'Finance', 'Accountant', 7500000, '2022-06-10'),
('Dewi', 'Anggraini', 'dewi.anggraini@company.com', 'Marketing', 'Marketing Specialist', 7000000, '2023-02-01'),
('Rizki', 'Pratama', 'rizki.pratama@company.com', 'IT', 'System Administrator', 8000000, '2021-11-05'),
('Maya', 'Sari', 'maya.sari@company.com', 'Finance', 'Financial Analyst', 8200000, '2022-08-15'),
('Joko', 'Widodo', 'joko.widodo@company.com', 'Operations', 'Operations Manager', 11000000, '2020-05-12'),
('Linda', 'Permata', 'linda.permata@company.com', 'Marketing', 'Digital Marketer', 6800000, '2023-01-30'),
('Fajar', 'Nugroho', 'fajar.nugroho@company.com', 'IT', 'Web Developer', 7800000, '2022-09-22'),
('Rina', 'Wulandari', 'rina.wulandari@company.com', 'HR', 'Recruitment Specialist', 6500000, '2023-03-10'),
('Hendra', 'Kurniawan', 'hendra.kurniawan@company.com', 'Finance', 'Tax Officer', 7200000, '2022-04-18'),
('Dian', 'Puspita', 'dian.puspita@company.com', 'IT', 'Database Administrator', 9000000, '2021-07-25'),
('Eko', 'Supriyanto', 'eko.supriyanto@company.com', 'Operations', 'Logistics Coordinator', 6000000, '2023-05-05'),
('Fitri', 'Handayani', 'fitri.handayani@company.com', 'Marketing', 'Content Creator', 5800000, '2023-04-12'),
('Gita', 'Maharani', 'gita.maharani@company.com', 'HR', 'Training Officer', 6200000, '2022-12-01'),
('Irfan', 'Setiawan', 'irfan.setiawan@company.com', 'IT', 'Network Engineer', 8300000, '2021-09-14'),
('Kartika', 'Dewi', 'kartika.dewi@company.com', 'Finance', 'Auditor', 7700000, '2022-03-08'),
('Lukman', 'Hakim', 'lukman.hakim@company.com', 'Operations', 'Warehouse Manager', 7300000, '2021-12-20'),
('Nina', 'Zahra', 'nina.zahra@company.com', 'Marketing', 'Social Media Specialist', 5900000, '2023-06-25'),
('Oscar', 'Fernando', 'oscar.fernando@company.com', 'IT', 'Mobile Developer', 8100000, '2022-11-11');

INSERT INTO projects (project_name, department, budget, start_date, end_date,
status) VALUES
('Website Redesign', 'IT', 150000000, '2024-01-01', '2024-06-30', 'Active'),
('Employee Training Program', 'HR', 75000000, '2024-02-01', '2024-05-31', 'Active'),
('Financial System Upgrade', 'Finance', 200000000, '2024-03-01', '2024-08-31', 'Planning'),
('Digital Marketing Campaign', 'Marketing', 120000000, '2024-01-15', '2024-04-30', 'Active'),
('Warehouse Optimization', 'Operations', 90000000, '2024-02-20', '2024-07-15', 'Active'),
('Mobile App Development', 'IT', 180000000, '2024-03-10', '2024-09-30', 'Planning'),
('Recruitment Drive 2024', 'HR', 50000000, '2024-04-01', '2024-06-30', 'Active'),
('Customer Satisfaction Survey', 'Marketing', 40000000, '2024-03-15', '2024-05-31', 'Active'),
('Network Infrastructure', 'IT', 220000000, '2024-05-01', '2024-12-31', 'Planning'),
('Annual Audit Preparation', 'Finance', 60000000, '2024-04-15', '2024-07-31', 'Active');

-- VIEW 1: Employee Summary dengan informasi lengkap
CREATE VIEW employee_summary AS
SELECT
 	id,
 	CONCAT(first_name, ' ', last_name) AS full_name,
 	department,
 	position,
 	salary,
 	EXTRACT(YEAR FROM AGE(CURRENT_DATE, hire_date)) AS years_of_service,
 	CASE
 		WHEN EXTRACT(YEAR FROM AGE(CURRENT_DATE, hire_date)) >= 3 THEN 'Senior'
 		WHEN EXTRACT(YEAR FROM AGE(CURRENT_DATE, hire_date)) >= 1 THEN
'Intermediate'
 		ELSE 'Junior'
 	END AS experience_level
FROM employees
ORDER BY department, salary DESC;

select * from employee_summary;

-- VIEW 2: Department Statistics
CREATE VIEW department_stats AS
SELECT
	department,
	COUNT(*) as total_employees,
	ROUND(AVG(salary), 2) as avg_salary,
	MIN(salary) as min_salary,
	MAX(salary) as max_salary,
	SUM(salary) as total_salary_budget
FROM employees
GROUP BY department
ORDER BY total_employees DESC;

select * from department_stats;

-- MATERIALIZED VIEW 1: Dashboard Summary
CREATE MATERIALIZED VIEW dashboard_summary AS
SELECT
	-- Total counts
	(SELECT COUNT(*) FROM employees) as total_employees,
	(SELECT COUNT(*) FROM projects) as total_projects,
	(SELECT COUNT(DISTINCT department) FROM employees) as total_departments,

	-- Salary statistics
	(SELECT ROUND(AVG(salary), 2) FROM employees) as company_avg_salary,
	(SELECT MAX(salary) FROM employees) as highest_salary,
	(SELECT MIN(salary) FROM employees) as lowest_salary,

	-- Project statistics
	(SELECT SUM(budget) FROM projects) as total_project_budget,
	(SELECT COUNT(*) FROM projects WHERE status = 'Active') as active_projects,
	(SELECT COUNT(*) FROM projects WHERE status = 'Planning') as planning_projects,

	-- Employee tenure
	(SELECT ROUND(AVG(EXTRACT(YEAR FROM AGE(CURRENT_DATE, hire_date))), 1) FROM employees) as avg_years_service;

select * from dashboard_summary;

-- Refresh materialized view
REFRESH MATERIALIZED VIEW dashboard_summary;

-- Function 1: Get Employees by Salary Range
CREATE OR REPLACE FUNCTION get_employees_by_salary_range(
    min_salary DECIMAL,
    max_salary DECIMAL
)
RETURNS TABLE (
    id INT,
    full_name VARCHAR,
    department VARCHAR,
    "position" VARCHAR,  
    salary DECIMAL
) AS $$
BEGIN
    RETURN QUERY
    SELECT 
        e.id,
        CONCAT(e.first_name, ' ', e.last_name)::VARCHAR AS full_name,
        e.department,
        e."position",  
        e.salary
    FROM employees e
    WHERE e.salary BETWEEN min_salary AND max_salary
    ORDER BY e.salary ASC;
END;
$$ LANGUAGE plpgsql;

SELECT * FROM get_employees_by_salary_range(8000000,9000000);

-- Function 2: Get Department Summary
CREATE OR REPLACE FUNCTION get_department_summary()
RETURNS TABLE (
    department VARCHAR,
    employee_count BIGINT,
    avg_salary DECIMAL,
    total_budget DECIMAL
) AS $$
BEGIN
    RETURN QUERY
    SELECT 
        e.department,
        COUNT(*) AS employee_count,
        ROUND(AVG(e.salary), 2) AS avg_salary,
        SUM(e.salary) AS total_budget
    FROM employees e
    GROUP BY e.department
    ORDER BY e.department;
END;
$$ LANGUAGE plpgsql;

SELECT * FROM get_department_summary();

