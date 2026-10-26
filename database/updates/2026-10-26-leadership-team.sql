-- ============================================================================
-- Update for a site that already ran schema.sql + seed.sql before the
-- Leadership Team was added to the admin area. Import ONCE in phpMyAdmin
-- (select the database → Import → this file → Go).
-- Adds the team_members table, the "Manage leadership team" permission
-- (Administrators only), and the six people from the old about.html.
-- ============================================================================

SET NAMES utf8mb4;

-- About page: Leadership Team.
CREATE TABLE team_members (
    id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name           VARCHAR(120) NOT NULL,
    title          VARCHAR(120) NOT NULL,
    bio            TEXT         NULL,
    image_path     VARCHAR(255) NULL,
    image_position ENUM('top','upper','center') NOT NULL DEFAULT 'top',
    status         ENUM('draft','published') NOT NULL DEFAULT 'draft',
    sort_order     INT          NOT NULL DEFAULT 0,
    created_by     INT UNSIGNED NULL,
    updated_by     INT UNSIGNED NULL,
    created_at     TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at     TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at     DATETIME     NULL,
    CONSTRAINT fk_team_creator FOREIGN KEY (created_by) REFERENCES users (id) ON DELETE SET NULL,
    CONSTRAINT fk_team_editor  FOREIGN KEY (updated_by) REFERENCES users (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO permissions (slug, name, sort_order) VALUES ('team.manage', 'Manage leadership team', 45);

INSERT INTO role_permissions (role_id, permission_id)
SELECT r.id, p.id FROM roles r JOIN permissions p ON p.slug = 'team.manage' WHERE r.slug = 'admin';

INSERT INTO team_members (name, title, bio, image_path, image_position, status, sort_order) VALUES
    ('Beatrice Kafwembe', 'Volunteer Board Member', 'A public health, Educationist, community development, Research, and mental Health specialist with over 8 years of experience advancing health, education, community development,  Research, and mental well-being programs. She has worked with USAID, the United Nations, international NGOs, and local partners to deliver evidence-based, people-centered solutions that strengthen communities and promote equitable health outcomes.member of the Liquid Barrier USA as the Voice of Africa and member of the EU-AU youth voice lab.', 'assets/images/team/Executive director.jpeg', 'top', 'published', 1),
    ('Beatrice Saizalo', 'Volunteer Board Member', 'An educator, community development practitioner, child protection and safeguarding professional, and humanitarian with over four years of experience in teaching, case management support, and delivering community-based social services for vulnerable children and families. A member of the AU–EU Youth Voices Lab and currently pursuing an MBA at the University of Zambia. Passionate about empowering communities, advancing child protection, promoting social inclusion, and driving sustainable development through education, advocacy, and youth engagement.', 'assets/images/team/Chief Executive officer.jpeg', 'top', 'published', 2),
    ('Temwani Zangi Zgambo', 'Volunteer Board Member', 'An IT and data management professional, systems administrator, and founder of Doubl Z Tech Solutions, based in Lusaka, Zambia. With over five years of experience spanning technical support, systems administration, monitoring and evaluation, and learning management systems, he has worked across healthcare, education, and nonprofit environments, supporting organisations in building reliable IT infrastructure and data-driven programme systems. He is passionate about using technology to solve real problems.', 'assets/images/team/Board chaiperson.png', 'top', 'published', 3),
    ('Benjamin Zulu', 'Finance Manager', 'An accountant with over five years of experience and a law school graduate — bringing dual expertise in finance and legal compliance to every engagement. His approach is built on precision, integrity, and relentless follow-through, turning complex numbers and legal requirements into clear, actionable strategy. Motivated, ambitious, and known for a no-shortcuts work ethic, he helps organisations stay compliant, protect their interests, and grow with confidence — and is passionate about making a difference in less-privileged communities.', 'assets/images/team/Finance.jpeg', 'top', 'published', 4),
    ('Moka Mulobela', 'Board Member', 'A highly motivated and passionate educator and community developer with over four years of teaching experience. A driving force in creating vibrant, effective learning environments — with the ability to communicate complex information clearly and accessibly. An approachable community development worker with the experience, skills, and qualifications to support planning, research, and knowledge processes across a variety of organisations.', 'assets/images/team/Board member.jpeg', 'top', 'published', 5),
    ('Mwansa Zulu', 'Secretary', 'A manager responsible for overseeing, leading, and coordinating operations — handling administrative duties, bridging the gap between staff and upper-level administration, and ensuring resources are used efficiently to achieve organisational goals. She also brings strong customer service skills including empathy, problem solving, communication, active listening, patience, and adaptability.', 'assets/images/team/Secretary.jpeg', 'upper', 'published', 6);
