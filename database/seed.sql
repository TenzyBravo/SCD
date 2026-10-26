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
    ('audit.view',      'View the audit log',         70),
    ('team.manage',     'Manage leadership team',     45);

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

-- Leadership Team previously hard-coded in about.html.
INSERT INTO team_members (name, title, bio, image_path, image_position, status, sort_order) VALUES
    ('Beatrice Kafwembe', 'Volunteer Board Member', 'A public health, Educationist, community development, Research, and mental Health specialist with over 8 years of experience advancing health, education, community development,  Research, and mental well-being programs. She has worked with USAID, the United Nations, international NGOs, and local partners to deliver evidence-based, people-centered solutions that strengthen communities and promote equitable health outcomes.member of the Liquid Barrier USA as the Voice of Africa and member of the EU-AU youth voice lab.', 'assets/images/team/Executive director.jpeg', 'top', 'published', 1),
    ('Beatrice Saizalo', 'Volunteer Board Member', 'An educator, community development practitioner, child protection and safeguarding professional, and humanitarian with over four years of experience in teaching, case management support, and delivering community-based social services for vulnerable children and families. A member of the AU–EU Youth Voices Lab and currently pursuing an MBA at the University of Zambia. Passionate about empowering communities, advancing child protection, promoting social inclusion, and driving sustainable development through education, advocacy, and youth engagement.', 'assets/images/team/Chief Executive officer.jpeg', 'top', 'published', 2),
    ('Temwani Zangi Zgambo', 'Volunteer Board Member', 'An IT and data management professional, systems administrator, and founder of Doubl Z Tech Solutions, based in Lusaka, Zambia. With over five years of experience spanning technical support, systems administration, monitoring and evaluation, and learning management systems, he has worked across healthcare, education, and nonprofit environments, supporting organisations in building reliable IT infrastructure and data-driven programme systems. He is passionate about using technology to solve real problems.', 'assets/images/team/Board chaiperson.png', 'top', 'published', 3),
    ('Benjamin Zulu', 'Finance Manager', 'An accountant with over five years of experience and a law school graduate — bringing dual expertise in finance and legal compliance to every engagement. His approach is built on precision, integrity, and relentless follow-through, turning complex numbers and legal requirements into clear, actionable strategy. Motivated, ambitious, and known for a no-shortcuts work ethic, he helps organisations stay compliant, protect their interests, and grow with confidence — and is passionate about making a difference in less-privileged communities.', 'assets/images/team/Finance.jpeg', 'top', 'published', 4),
    ('Moka Mulobela', 'Board Member', 'A highly motivated and passionate educator and community developer with over four years of teaching experience. A driving force in creating vibrant, effective learning environments — with the ability to communicate complex information clearly and accessibly. An approachable community development worker with the experience, skills, and qualifications to support planning, research, and knowledge processes across a variety of organisations.', 'assets/images/team/Board member.jpeg', 'top', 'published', 5),
    ('Mwansa Zulu', 'Secretary', 'A manager responsible for overseeing, leading, and coordinating operations — handling administrative duties, bridging the gap between staff and upper-level administration, and ensuring resources are used efficiently to achieve organisational goals. She also brings strong customer service skills including empathy, problem solving, communication, active listening, patience, and adaptability.', 'assets/images/team/Secretary.jpeg', 'upper', 'published', 6);