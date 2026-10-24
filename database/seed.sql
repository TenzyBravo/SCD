-- ============================================================================
-- Roles, permissions, and the content that was hard-coded in the old pages.
-- Run after schema.sql. No user accounts are created here: the first
-- administrator is created in the browser at /admin/setup.
-- ============================================================================

SET NAMES utf8mb4;

INSERT INTO permissions (slug, name, sort_order) VALUES
    ('news.manage',     'Manage news & media',        10),
    ('toolkits.manage', 'Manage toolkits & downloads', 20),
    ('jobs.manage',     'Manage job vacancies',       30),
    ('training.manage', 'Manage training courses',    40),
    ('users.manage',    'Manage staff accounts',      50),
    ('roles.manage',    'Manage role permissions',    60),
    ('audit.view',      'View the audit log',         70);

INSERT INTO roles (slug, name, description) VALUES
    ('admin',          'Administrator',    'Full access, including staff accounts, permissions and the audit log.'),
    ('editor',         'Content Editor',   'Manages all public content: news, toolkits, jobs and training.'),
    ('communications', 'Communications',   'Manages news & media and toolkits.'),
    ('hr',             'HR Officer',       'Manages job vacancies.'),
    ('training',       'Training Officer', 'Manages training courses.');

INSERT INTO role_permissions (role_id, permission_id)
SELECT r.id, p.id FROM roles r JOIN permissions p
WHERE (r.slug = 'admin')
   OR (r.slug = 'editor'         AND p.slug IN ('news.manage','toolkits.manage','jobs.manage','training.manage'))
   OR (r.slug = 'communications' AND p.slug IN ('news.manage','toolkits.manage'))
   OR (r.slug = 'hr'             AND p.slug = 'jobs.manage')
   OR (r.slug = 'training'       AND p.slug = 'training.manage');

-- Vacancies previously hard-coded in jobs.html.
INSERT INTO jobs (title, location, commitment, deadline, description, how_to_apply, status, sort_order) VALUES
    ('Volunteer Board Advisory Member', 'Remote — Worldwide', 'Voluntary advisory role', '2026-08-30',
     'Provide strategic guidance to a growing Zambian NGO. Seeking experienced NGO professionals (6+ years) with expertise in fundraising, donor engagement, grant writing, governance, programme development, financial management, or organisational development. Help shape SCD''s long-term sustainability and community impact.',
     'Send CV and a brief expression of interest to thesafecenterfordevelopment@gmail.com with subject "Application Volunteer Board Advisory Member".',
     'published', 1),
    ('Remote Volunteer Fundraiser (20 positions)', 'Remote — Worldwide', '3-month voluntary role · 2–3 hrs/day', NULL,
     'Support the “Buy a Malnourished Child Soya” campaign. Includes fundraising training, mentorship, certificate of completion, and a potential recommendation letter. Requires a K300 training fee, Grade 12 certificate, and a diploma/degree (or in progress) in Social Work, Community Development, Marketing, PR or related field.',
     NULL, 'published', 2);

-- Courses previously hard-coded in training.html.
INSERT INTO courses (title, tag, details, image_path, status, sort_order) VALUES
    ('Community Health Workers Certification', 'In-person · Lusaka', '4-week program · Starts April 15, 2026 · Ministry of Health accredited.', 'assets/images/programs/mentonship.jpeg', 'published', 1),
    ('Monitoring & Evaluation Fundamentals',   'Online',             'Self-paced · 20 hours · Certificate on completion.',                     'assets/images/programs/Monitoring & Evaluation Fundamentals.jpeg', 'published', 2),
    ('Safeguarding & Child Protection',        'Workshop',           '2-day intensive · May 8–9, 2026 · Ndola.',                               'assets/images/programs/child safeguarding.jpeg', 'published', 3),
    ('Gender-Responsive Programming',          'Online',             'Self-paced · 15 hours · CPD accredited.',                                'assets/images/programs/Gender.jpeg', 'published', 4),
    ('Grants Management for NGOs',             'Hybrid',             '3-day program · June 2026 · Blend of online and in-person.',             'assets/images/programs/grants.jpeg', 'published', 5),
    ('Climate-Smart Agriculture',              'In-person',          'Field-based · 5 days · Kabwe · Farmer-focused curriculum.',              'assets/images/programs/Climate-Smart Agriculture.jpeg', 'published', 6);
