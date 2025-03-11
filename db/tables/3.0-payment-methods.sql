-- ----------------------------
-- METODOS DE PAGO INICIALES --
-- ----------------------------
INSERT INTO `payment_methods` (`id`, `status`, `icon`, `name`, `description`, `need_country`) VALUES
('bank', 'active', '6717d38f5974f.png', 'Banco', 'Recibir o realizar pagos a través de transferencias bancarias locales. Cada entidad bancaria debe estar asociada a un país específico.', 1),
('card', 'active', '6717d32780e52.png', 'Tarjeta', 'Recibir pagos con tarjeta de débito o crédito.', 0),
('cash', 'active', '6717d4bc88c72.png', 'Efectivo', 'Recibir o realizar pagos a través de envíos de dinero en efectivo local, cada procesador debe estar anclado a un país específico.', 1),
('crypto', 'active', '6717d15db8583.png', 'Criptomoneda', 'Recibir o realizar pagos con criptomonedas a través de transferencia directa.', 0),
('gift-card', 'active', '6717d54c45c0d.png', 'Tarjeta de regalo', 'Recibir o realizar pagos a través vales, bonos, trajetas de regalo, etc.', 0),
('mobile', 'active', '6717d3d978a95.png', 'Móvil', 'Recibir o realizar pagos a través de pago móvil local. Cada pago móvil debe estar anclado a un país específico.', 1),
('platform', 'active', '671bb13a68ab5.png', 'Plataforma Local', 'Recibir pagos a través de plataformas de pago locales a través de plataformas web, links de pago u otros medios locales. Cada plataforma debe estar anclada a un país específico.', 1),
('wallet', 'active', '6717d41a0b062.png', 'Monedero electrónico', 'Recibir o realizar pagos a través de monederos electrónicos (wallets).', 0);