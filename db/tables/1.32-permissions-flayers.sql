
-- FOLLETOS 
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'flayers');

INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
(1, 'master', 'access|flayers'),
(1, 'admin', 'access|flayers'),
(1, 'coord', 'access|flayers'),
(1, 'agent', 'access|flayers'),
(1, 'office', 'access|flayers'),
(0, 'client', 'access|flayers'),
(1, 'assist-1', 'access|flayers'),
(1, 'assist-2', 'access|flayers'),
(1, 'assist-3', 'access|flayers'),
(1, 'assist-4', 'access|flayers'),
(1, 'assist-5', 'access|flayers');