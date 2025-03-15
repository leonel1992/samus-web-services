
-- REGISTROS 
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'records');

INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
(1, 'master', 'access|records'),
(1, 'admin', 'access|records'),
(1, 'coord', 'access|records'),
(0, 'agent', 'access|records'),
(0, 'office', 'access|records'),
(0, 'client', 'access|records'),
(0, 'assist-1', 'access|records'),
(0, 'assist-2', 'access|records'),
(0, 'assist-3', 'access|records'),
(0, 'assist-4', 'access|records'),
(0, 'assist-5', 'access|records');