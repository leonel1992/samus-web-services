
-- PROCESADORES 
INSERT IGNORE INTO `processors` (`id`, `invert`, `icon`, `name`, `payment`, `country`, `currency`, `status_buy`, `status_sell`) VALUES
('bank-bol-banco-union', 0, '671c10d69b9cf.png', 'Banco Unión', 'bank', 'bol', 'bob', 0, 0),
('bank-bra-santander', 0, '671c0d6926878.png', 'Santander', 'bank', 'bra', 'brl', 0, 0),
('bank-chl-banco-de-chile', 0, '671bf7e25d9a3.png', 'Banco de Chile', 'bank', 'chl', 'clp', 0, 0),
('bank-chl-banco-estado', 0, '671bf7beb38d6.png', 'Banco Estado', 'bank', 'chl', 'clp', 0, 0),
('bank-chl-santander', 0, '671bf80d700df.png', 'Santander', 'bank', 'chl', 'clp', 0, 0),
('bank-col-bancolombia', 1, '671bbe276aaac.png', 'Bancolombia', 'bank', 'col', 'cop', 0, 0),
('bank-col-davivienda', 1, '671bbe3faa5f6.png', 'Davivienda', 'bank', 'col', 'cop', 0, 0),
('bank-cri-bac-san-jose', 0, '671c0cc48df09.png', 'BAC San José', 'bank', 'cri', 'crc', 0, 0),
('bank-cri-banco-nacional', 0, '671c0cd023373.png', 'Banco Nacional', 'bank', 'cri', 'crc', 0, 0),
('bank-cri-bcr', 0, '671c0cdae3060.png', 'BCR', 'bank', 'cri', 'crc', 0, 0),
('bank-dom-banco-del-progreso', 0, '671c0af1536c2.png', 'Banco del Progreso', 'bank', 'dom', 'dop', 0, 0),
('bank-dom-banco-popular', 0, '671c0a5879944.png', 'Banco Popular', 'bank', 'dom', 'dop', 0, 0),
('bank-dom-banco-santa-cruz', 0, '671c0b101498e.png', 'Banco Santa Cruz', 'bank', 'dom', 'dop', 0, 0),
('bank-dom-banreservas', 0, '671c0a3c2a9ea.png', 'BanReservas', 'bank', 'dom', 'dop', 0, 0),
('bank-dom-bhd-leon', 0, '671c0acd20da3.png', 'BHD León', 'bank', 'dom', 'dop', 0, 0),
('bank-dom-scotiabank', 0, '671c0b293fe4d.png', 'Scotiabank', 'bank', 'dom', 'dop', 0, 0),
('bank-ecu-banco-guayaquil', 0, '671bfcb044f9c.png', 'Banco Guayaquil', 'bank', 'ecu', 'usd', 0, 0),
('bank-ecu-banco-pichincha', 0, '671bfc7cdcf71.png', 'Banco Pichincha', 'bank', 'ecu', 'usd', 0, 0),
('bank-ecu-produbanco', 0, '671bfcc92703a.png', 'Produbanco', 'bank', 'ecu', 'usd', 0, 0),
('bank-esp-abanca', 0, '671c0545b24f6.png', 'Abanca', 'bank', 'esp', 'eur', 0, 0),
('bank-esp-bankia', 0, '671c057f693d5.png', 'Bankia', 'bank', 'esp', 'eur', 0, 0),
('bank-esp-bbva', 0, '671c059f3b6d0.png', 'BBVA', 'bank', 'esp', 'eur', 0, 0),
('bank-esp-caixabank', 0, '671c05b139d1a.png', 'CaixaBank', 'bank', 'esp', 'eur', 0, 0),
('bank-esp-cajamar', 0, '671c066b6d5f9.png', 'Cajamar', 'bank', 'esp', 'eur', 0, 0),
('bank-esp-ing', 0, '671c05c249733.png', 'ING', 'bank', 'esp', 'eur', 0, 0),
('bank-esp-liberbank', 0, '671c063824f8d.png', 'Liberbank', 'bank', 'esp', 'eur', 0, 0),
('bank-esp-santander', 0, '671c06483463c.png', 'Santander', 'bank', 'esp', 'eur', 0, 0),
('bank-mex-bancoppel', 0, '671c035b19d8b.png', 'BanCoppel', 'bank', 'mex', 'mxn', 0, 0),
('bank-mex-banregio', 0, '671c03515580d.png', 'BanRegio', 'bank', 'mex', 'mxn', 0, 0),
('bank-mex-scotiabank', 0, '671c0267f399d.png', 'Scotiabank', 'bank', 'mex', 'mxn', 0, 0),
('bank-pan-banco-general', 0, '671bc1c106073.png', 'Banco General', 'bank', 'pan', 'pab', 0, 0),
('bank-pan-banesco', 0, '671bc1cde5cc3.png', 'Banesco', 'bank', 'pan', 'pab', 0, 0),
('bank-pan-mercantil', 0, '671bc1da4a323.png', 'Mercantil', 'bank', 'pan', 'pab', 0, 0),
('bank-per-bbva', 0, '671bfa76e9297.png', 'BBVA', 'bank', 'per', 'pen', 0, 0),
('bank-per-bcp', 0, '671bfa83aba2b.png', 'BCP', 'bank', 'per', 'pen', 0, 0),
('bank-per-interbank', 0, '671bfa917953f.png', 'Interbank', 'bank', 'per', 'pen', 0, 0),
('bank-per-scotiabank', 0, '671bfb1b406ab.png', 'Scotiabank', 'bank', 'per', 'pen', 0, 0),
('bank-prt-novo-banco', 0, '671c081219c57.png', 'Novo Banco', 'bank', 'prt', 'eur', 0, 0),
('bank-ury-banco-itau', 0, '671c0f5bbc204.png', 'Banco Itaú', 'bank', 'ury', 'uyu', 0, 0),
('bank-ury-banco-santander', 0, '671c0f722837e.png', 'Banco Santander', 'bank', 'ury', 'uyu', 0, 0),
('bank-usa-bank-of-america', 0, '671bc43bc3a93.png', 'Bank of America', 'bank', 'usa', 'usd', 0, 0),
('bank-ven-banco-de-venezuela', 0, '671bb5c8d86df.png', 'Banco de Venezuela', 'bank', 'ven', 'ves', 0, 0),
('bank-ven-banesco', 0, '671bb616772f5.png', 'Banesco', 'bank', 'ven', 'ves', 0, 0),
('bank-ven-mercantil', 0, '671bb62950ad6.png', 'Mercantil', 'bank', 'ven', 'ves', 0, 0),
('bank-ven-provincial', 0, '671bb63a07425.png', 'Provincial', 'bank', 'ven', 'ves', 0, 0),
('card-col-datafono-digital', 1, '671bbbb9c7257.png', 'Datáfono Digital', 'card', 'col', 'cop', 0, 0),
('cash-arg-western-union', 0, '671c01600b2f0.png', 'Western Union', 'cash', 'arg', 'ars', 0, 0),
('cash-bol-western-union', 0, '671c0fead8754.png', 'Western Union', 'cash', 'bol', 'bob', 0, 0),
('cash-bra-western-union', 0, '671c0d4ea2e62.png', 'Western Union', 'cash', 'bra', 'brl', 0, 0),
('cash-chl-western-union', 0, '671bf71f7b9ca.png', 'Western Union', 'cash', 'chl', 'clp', 0, 0),
('cash-col-efectivo', 1, '671bbe5ad6a38.png', 'Efectivo', 'cash', 'col', 'cop', 0, 0),
('cash-col-efecty', 1, '671bbe68cef4c.png', 'Efecty', 'cash', 'col', 'cop', 0, 0),
('cash-col-western-union', 1, '671bc272d9cb4.png', 'Western Union', 'cash', 'col', 'cop', 0, 0),
('cash-cri-western-union', 0, '671c0b929bb5e.png', 'Western Union', 'cash', 'cri', 'crc', 0, 0),
('cash-ecu-western-union', 0, '671bfce2613a8.png', 'Western Union', 'cash', 'ecu', 'usd', 0, 0),
('cash-esp-western-union', 0, '671c06dcc8dc0.png', 'Western Union', 'cash', 'esp', 'eur', 0, 0),
('cash-mex-oxxo', 0, '671c034481eb3.png', 'OXXO', 'cash', 'mex', 'mxn', 0, 0),
('cash-mex-western-union', 0, '671c022e5d9dd.png', 'Western Union', 'cash', 'mex', 'mxn', 0, 0),
('cash-pan-western-union', 0, '671bc0e82f318.png', 'Western Union', 'cash', 'pan', 'pab', 0, 0),
('cash-per-western-union', 0, '671bf8e933a43.png', 'Western Union', 'cash', 'per', 'pen', 0, 0),
('cash-prt-western-union', 0, '671c078c77d4c.png', 'Western Union', 'cash', 'prt', 'eur', 0, 0),
('cash-ury-western-union', 0, '671c0ea8e0b95.png', 'Western Union', 'cash', 'ury', 'uyu', 0, 0),
('cash-usa-western-union', 0, '671bc47089348.png', 'Western Union', 'cash', 'usa', 'usd', 0, 0),
('cash-ven-avance-efectivo-usd', 0, '671c1345b5775.png', 'Avance Efectivo USD', 'cash', 'ven', 'usd', 0, 0),
('mobile-bol-tigo-money', 0, '671c10ea83703.png', 'Tigo Money', 'mobile', 'bol', 'bob', 0, 0),
('mobile-bra-pix', 0, '671c0dbfe67a4.png', 'Pix', 'mobile', 'bra', 'brl', 0, 0),
('mobile-col-daviplata', 1, '671bbe7ca488f.png', 'Daviplata', 'mobile', 'col', 'cop', 0, 0),
('mobile-col-movii', 1, '671bbe8eb92c6.png', 'Movii', 'mobile', 'col', 'cop', 'blocked', 'blocked'),
('mobile-col-nequi', 1, '671bbe9b6a2f7.png', 'Nequi', 'mobile', 'col', 'cop', 0, 0),
('mobile-col-transfiya', 1, '671bf8926d56d.png', 'Transfiya', 'mobile', 'col', 'cop', 0, 0),
('mobile-esp-bizum', 0, '671c06fa7efee.png', 'Bizum', 'mobile', 'esp', 'eur', 0, 0),
('mobile-pan-mony', 0, '671bc1f06aae7.png', 'Mony', 'mobile', 'pan', 'pab', 0, 0),
('mobile-pan-yappy', 0, '671bc1fb46e1a.png', 'Yappy', 'mobile', 'pan', 'pab', 0, 0),
('mobile-per-yape', 0, '671bfb2c6cd5a.png', 'Yape', 'mobile', 'per', 'pen', 0, 0),
('mobile-ury-mi-dinero', 0, '671c0f2dd23f7.png', 'Mi Dinero', 'mobile', 'ury', 'uyu', 0, 0),
('mobile-ury-prex', 0, '671c0f3b49d74.png', 'Prex', 'mobile', 'ury', 'uyu', 0, 0),
('mobile-usa-zelle', 0, '671bc456e20ba.png', 'Zelle', 'mobile', 'usa', 'usd', 0, 0),
('mobile-ven-pago-movil', 0, '671bb65117362.png', 'Pago Móvil', 'mobile', 'ven', 'ves', 0, 0),
('platform-per-bcp-giros', 0, '671bfa64cb341.png', 'BCP Giros', 'platform', 'per', 'pen', 0, 0),
('wallet-airtm', 0, '671c1335375e2.png', 'Airtm', 'wallet', NULL, 'usd', 0, 0),
('wallet-arg-lemon-cash', 0, '671c01313392e.png', 'Lemon Cash', 'wallet', 'arg', 'ars', 0, 0),
('wallet-arg-naranja-x', 0, '671c01027d933.png', 'Naranja X', 'wallet', 'arg', 'ars', 0, 0),
('wallet-arg-uala', 0, '671c019214f52.png', 'Uala', 'wallet', 'arg', 'ars', 0, 0),
('wallet-binance', 0, '671c1472eca51.png', 'Binance', 'wallet', NULL, 'usdt', 0, 0),
('wallet-payoneer', 0, '671c1351c1859.png', 'Payoneer', 'wallet', NULL, 'usd', 0, 0),
('wallet-paypal', 0, '671c135e0eb68.png', 'PayPal', 'wallet', NULL, 'usd', 0, 0),
('wallet-skrill', 0, '671c13267c13d.png', 'Skrill', 'wallet', NULL, 'usd', 0, 0),
('wallet-uphold', 0, '671c1319f3dda.png', 'Uphold', 'wallet', NULL, 'usd', 0, 0);