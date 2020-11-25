/*
 Navicat Premium Data Transfer

 Source Server         : LOCALHOST
 Source Server Type    : MySQL
 Source Server Version : 100411
 Source Host           : localhost:3306
 Source Schema         : capshop

 Target Server Type    : MySQL
 Target Server Version : 100411
 File Encoding         : 65001

 Date: 24/11/2020 21:14:32
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for banners
-- ----------------------------
DROP TABLE IF EXISTS `banners`;
CREATE TABLE `banners`  (
  `idbanners` int(11) NOT NULL AUTO_INCREMENT,
  `imagen` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `url` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1 COMMENT '0 - desactivo\n1 - activo\n',
  `titulo` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `estatustexto` int(11) NOT NULL DEFAULT 0 COMMENT '0 - Mostrar titulo y descripcion\n1 - quitar titulo y descripcion',
  `t_banner` int(11) NOT NULL DEFAULT 0 COMMENT '0 - pagina web\n1 - app',
  PRIMARY KEY (`idbanners`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of banners
-- ----------------------------
INSERT INTO `banners` VALUES (1, 'CIC2.jpg', 'mes de marzo', 'http://capse.mx/capshop/', 1, 'PROMOCIONES', 1, 0);
INSERT INTO `banners` VALUES (2, 'banner2.png', '', 'http://capse.mx/capshop/', 1, 'BIENVENIDO', 1, 0);

-- ----------------------------
-- Table structure for bitacora
-- ----------------------------
DROP TABLE IF EXISTS `bitacora`;
CREATE TABLE `bitacora`  (
  `idbitacora` int(11) NOT NULL AUTO_INCREMENT,
  `idusuarios` int(11) NOT NULL,
  `direccion_ip` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `sistema_operativo` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `navegador` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `fecha_ingreso` datetime(0) NOT NULL,
  PRIMARY KEY (`idbitacora`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3527 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of bitacora
-- ----------------------------
INSERT INTO `bitacora` VALUES (3255, 1, '::1', 'Windows', 'Google Chrome', '2020-01-31 13:05:11');
INSERT INTO `bitacora` VALUES (3256, 1, '187.171.222.173', 'Mac OS', 'Firefox', '2020-02-06 18:10:30');
INSERT INTO `bitacora` VALUES (3257, 1, '187.171.222.173', 'Windows', 'Google Chrome', '2020-02-06 18:10:31');
INSERT INTO `bitacora` VALUES (3258, 1, '187.171.222.173', 'Windows', 'Firefox', '2020-02-06 18:10:34');
INSERT INTO `bitacora` VALUES (3259, 1, '187.171.222.173', 'Windows', 'Google Chrome', '2020-02-07 09:36:27');
INSERT INTO `bitacora` VALUES (3260, 1, '187.171.222.173', 'Mac OS', 'Google Chrome', '2020-02-10 13:03:18');
INSERT INTO `bitacora` VALUES (3261, 1, '187.171.222.173', 'Mac OS', 'Firefox', '2020-02-10 17:33:58');
INSERT INTO `bitacora` VALUES (3262, 1, 'Pagina web', 'Pagina web', 'Pagina web', '2020-02-11 11:50:06');
INSERT INTO `bitacora` VALUES (3263, 1, 'Pagina web', 'Pagina web', 'Pagina web', '2020-02-11 11:51:40');
INSERT INTO `bitacora` VALUES (3264, 1, '187.171.222.173', 'Mac OS', 'Google Chrome', '2020-02-11 11:52:27');
INSERT INTO `bitacora` VALUES (3265, 1, '187.171.222.173', 'Mac OS', 'Google Chrome', '2020-02-11 12:38:54');
INSERT INTO `bitacora` VALUES (3266, 1, '187.171.222.173', 'Windows', 'Google Chrome', '2020-02-11 12:58:42');
INSERT INTO `bitacora` VALUES (3267, 1, '::1', 'Windows', 'Google Chrome', '2020-02-11 14:51:52');
INSERT INTO `bitacora` VALUES (3268, 1, '::1', 'Windows', 'Google Chrome', '2020-02-11 15:16:00');
INSERT INTO `bitacora` VALUES (3269, 1, '::1', 'Windows', 'Google Chrome', '2020-02-11 15:26:08');
INSERT INTO `bitacora` VALUES (3270, 1, '::1', 'Windows', 'Google Chrome', '2020-02-12 18:45:10');
INSERT INTO `bitacora` VALUES (3271, 1, '::1', 'Windows', 'Google Chrome', '2020-02-13 05:36:52');
INSERT INTO `bitacora` VALUES (3272, 1, '::1', 'Windows', 'Google Chrome', '2020-02-13 06:03:12');
INSERT INTO `bitacora` VALUES (3273, 1, '::1', 'Windows', 'Google Chrome', '2020-02-13 13:51:06');
INSERT INTO `bitacora` VALUES (3274, 1, '::1', 'Windows', 'Google Chrome', '2020-02-13 15:40:47');
INSERT INTO `bitacora` VALUES (3275, 1, '187.171.106.211', 'Mac OS', 'Firefox', '2020-02-17 13:39:12');
INSERT INTO `bitacora` VALUES (3276, 1, '187.171.106.211', 'Mac OS', 'Firefox', '2020-02-17 14:10:16');
INSERT INTO `bitacora` VALUES (3277, 1, '187.171.106.211', 'Mac OS', 'Google Chrome', '2020-02-17 14:40:58');
INSERT INTO `bitacora` VALUES (3278, 1, '187.171.106.211', 'Mac OS', 'Google Chrome', '2020-02-17 14:47:35');
INSERT INTO `bitacora` VALUES (3279, 1, '187.171.106.211', 'Windows', 'Google Chrome', '2020-02-17 15:28:52');
INSERT INTO `bitacora` VALUES (3280, 1, '187.171.106.211', 'Mac OS', 'Google Chrome', '2020-02-17 16:22:45');
INSERT INTO `bitacora` VALUES (3281, 1, '187.171.106.211', 'Windows', 'Google Chrome', '2020-02-17 17:52:24');
INSERT INTO `bitacora` VALUES (3282, 1, '187.171.106.211', 'Windows', 'Google Chrome', '2020-02-17 19:00:28');
INSERT INTO `bitacora` VALUES (3283, 1, '187.171.106.211', 'Windows', 'Google Chrome', '2020-02-17 19:09:02');
INSERT INTO `bitacora` VALUES (3284, 1, '177.231.226.135', 'Windows', 'Google Chrome', '2020-02-17 20:44:01');
INSERT INTO `bitacora` VALUES (3285, 1, '177.231.232.44', 'Windows', 'Firefox', '2020-02-17 22:32:29');
INSERT INTO `bitacora` VALUES (3286, 1, '177.231.226.135', 'Windows', 'Google Chrome', '2020-02-17 23:55:18');
INSERT INTO `bitacora` VALUES (3287, 1, '177.231.232.44', 'Windows', 'Firefox', '2020-02-18 00:01:48');
INSERT INTO `bitacora` VALUES (3288, 1, '187.171.106.211', 'Mac OS', 'Firefox', '2020-02-18 10:52:36');
INSERT INTO `bitacora` VALUES (3289, 1, '187.171.106.211', 'Mac OS', 'Google Chrome', '2020-02-18 12:32:49');
INSERT INTO `bitacora` VALUES (3290, 1, '187.171.106.211', 'Windows', 'Google Chrome', '2020-02-18 14:43:26');
INSERT INTO `bitacora` VALUES (3291, 1, '187.171.106.211', 'Windows', 'Google Chrome', '2020-02-18 15:24:05');
INSERT INTO `bitacora` VALUES (3292, 1, '187.171.106.211', 'Windows', 'Google Chrome', '2020-02-18 15:32:22');
INSERT INTO `bitacora` VALUES (3293, 1, '187.171.173.30', 'Windows', 'Google Chrome', '2020-02-19 10:06:06');
INSERT INTO `bitacora` VALUES (3294, 1, '187.171.173.30', 'Mac OS', 'Firefox', '2020-02-19 10:57:41');
INSERT INTO `bitacora` VALUES (3295, 1, '187.171.173.30', 'Mac OS', 'Safari', '2020-02-19 11:16:03');
INSERT INTO `bitacora` VALUES (3296, 1, '187.171.173.30', 'Linux', 'Google Chrome', '2020-02-19 11:19:33');
INSERT INTO `bitacora` VALUES (3297, 1, '187.171.173.30', 'Linux', 'Google Chrome', '2020-02-19 11:19:38');
INSERT INTO `bitacora` VALUES (3298, 1, '187.171.173.30', 'Windows', 'Google Chrome', '2020-02-19 11:47:22');
INSERT INTO `bitacora` VALUES (3299, 1, '187.171.173.30', 'Mac OS', 'Google Chrome', '2020-02-19 11:51:58');
INSERT INTO `bitacora` VALUES (3300, 1, '187.171.173.30', 'Windows', 'Google Chrome', '2020-02-19 12:58:07');
INSERT INTO `bitacora` VALUES (3301, 1, '187.171.173.30', 'Mac OS', 'Google Chrome', '2020-02-19 13:50:31');
INSERT INTO `bitacora` VALUES (3302, 1, '187.242.232.46', 'Mac OS', 'Firefox', '2020-02-20 10:39:20');
INSERT INTO `bitacora` VALUES (3303, 1, '177.231.232.44', 'Windows', 'Firefox', '2020-02-20 21:36:16');
INSERT INTO `bitacora` VALUES (3304, 1, '189.148.61.47', 'Linux', 'Google Chrome', '2020-02-22 12:56:02');
INSERT INTO `bitacora` VALUES (3305, 1, '187.171.173.30', 'Mac OS', 'Google Chrome', '2020-02-24 14:26:14');
INSERT INTO `bitacora` VALUES (3306, 1, '187.171.173.30', 'Mac OS', 'Google Chrome', '2020-02-24 17:45:51');
INSERT INTO `bitacora` VALUES (3307, 1, '177.231.232.44', 'Windows', 'Firefox', '2020-02-24 22:00:53');
INSERT INTO `bitacora` VALUES (3308, 1, '187.171.92.72', 'Mac OS', 'Firefox', '2020-02-25 12:46:00');
INSERT INTO `bitacora` VALUES (3309, 1, '187.242.232.46', 'Mac OS', 'Google Chrome', '2020-02-25 13:35:17');
INSERT INTO `bitacora` VALUES (3310, 1, '187.171.199.107', 'Mac OS', 'Firefox', '2020-02-26 10:08:22');
INSERT INTO `bitacora` VALUES (3311, 1, '187.171.199.107', 'Mac OS', 'Firefox', '2020-02-26 12:08:58');
INSERT INTO `bitacora` VALUES (3312, 1, '187.171.199.107', 'Mac OS', 'Firefox', '2020-02-26 14:08:39');
INSERT INTO `bitacora` VALUES (3313, 1, '200.68.136.237', 'Linux', 'Google Chrome', '2020-02-27 12:32:59');
INSERT INTO `bitacora` VALUES (3314, 1, '200.68.136.237', 'Linux', 'Google Chrome', '2020-02-27 12:35:03');
INSERT INTO `bitacora` VALUES (3315, 1, '187.242.232.46', 'Mac OS', 'Firefox', '2020-02-27 12:35:10');
INSERT INTO `bitacora` VALUES (3316, 1, '187.242.232.46', 'Windows', 'Google Chrome', '2020-02-27 14:18:58');
INSERT INTO `bitacora` VALUES (3317, 1, '200.68.136.151', 'Linux', 'Google Chrome', '2020-02-27 14:19:27');
INSERT INTO `bitacora` VALUES (3318, 1, '187.242.232.46', 'Windows', 'Google Chrome', '2020-02-27 15:27:02');
INSERT INTO `bitacora` VALUES (3319, 1, '187.171.197.94', 'Mac OS', 'Google Chrome', '2020-02-27 22:29:31');
INSERT INTO `bitacora` VALUES (3320, 1, '187.171.197.94', 'Mac OS', 'Google Chrome', '2020-02-27 23:11:07');
INSERT INTO `bitacora` VALUES (3321, 1, '187.171.197.94', 'Mac OS', 'Firefox', '2020-02-28 10:11:49');
INSERT INTO `bitacora` VALUES (3322, 1, '187.171.197.94', 'Mac OS', 'Firefox', '2020-02-28 10:11:50');
INSERT INTO `bitacora` VALUES (3323, 1, '187.171.197.94', 'Windows', 'Google Chrome', '2020-02-28 10:45:00');
INSERT INTO `bitacora` VALUES (3324, 1, '177.231.232.44', 'Windows', 'Firefox', '2020-02-29 21:05:41');
INSERT INTO `bitacora` VALUES (3325, 1, '177.231.232.44', 'Windows', 'Firefox', '2020-03-01 16:57:44');
INSERT INTO `bitacora` VALUES (3326, 1, '189.129.169.163', 'Mac OS', 'Firefox', '2020-03-02 13:21:07');
INSERT INTO `bitacora` VALUES (3327, 1, '189.129.211.200', 'Windows', 'Google Chrome', '2020-03-03 10:50:42');
INSERT INTO `bitacora` VALUES (3328, 1, '189.129.211.200', 'Mac OS', 'Firefox', '2020-03-03 11:41:03');
INSERT INTO `bitacora` VALUES (3329, 1, '187.190.134.165', 'Mac OS', 'Google Chrome', '2020-03-06 10:46:13');
INSERT INTO `bitacora` VALUES (3330, 1, '189.129.216.191', 'Mac OS', 'Firefox', '2020-03-06 11:02:01');
INSERT INTO `bitacora` VALUES (3331, 1, '189.129.216.191', 'Mac OS', 'Firefox', '2020-03-06 11:33:43');
INSERT INTO `bitacora` VALUES (3332, 1, '187.190.134.165', 'Mac OS', 'Google Chrome', '2020-03-06 11:58:01');
INSERT INTO `bitacora` VALUES (3333, 1, '187.190.168.225', 'Mac OS', 'Google Chrome', '2020-03-06 21:54:28');
INSERT INTO `bitacora` VALUES (3334, 1, '187.190.168.225', 'Mac OS', 'Safari', '2020-03-07 11:48:06');
INSERT INTO `bitacora` VALUES (3335, 1, '187.190.168.225', 'Windows', 'Google Chrome', '2020-03-07 12:10:24');
INSERT INTO `bitacora` VALUES (3336, 1, '177.231.226.135', 'Linux', 'Google Chrome', '2020-03-07 23:50:06');
INSERT INTO `bitacora` VALUES (3337, 1, '189.148.12.65', 'Windows', 'Google Chrome', '2020-03-08 00:24:18');
INSERT INTO `bitacora` VALUES (3338, 1, '189.129.98.137', 'Mac OS', 'Firefox', '2020-03-09 15:39:07');
INSERT INTO `bitacora` VALUES (3339, 1, '189.129.98.137', 'Mac OS', 'Firefox', '2020-03-09 17:48:41');
INSERT INTO `bitacora` VALUES (3340, 1, '189.253.154.33', 'Mac OS', 'Google Chrome', '2020-03-09 21:33:02');
INSERT INTO `bitacora` VALUES (3341, 1, '189.129.98.137', 'Mac OS', 'Firefox', '2020-03-10 10:01:19');
INSERT INTO `bitacora` VALUES (3342, 1, '189.253.154.33', 'Mac OS', 'Google Chrome', '2020-03-10 10:30:44');
INSERT INTO `bitacora` VALUES (3343, 1, '189.253.154.33', 'Mac OS', 'Google Chrome', '2020-03-10 22:19:53');
INSERT INTO `bitacora` VALUES (3344, 1, '189.129.195.84', 'Mac OS', 'Firefox', '2020-03-17 12:18:04');
INSERT INTO `bitacora` VALUES (3345, 1, '189.129.195.84', 'Mac OS', 'Firefox', '2020-03-17 14:13:21');
INSERT INTO `bitacora` VALUES (3346, 1, '189.129.195.84', 'Mac OS', 'Firefox', '2020-03-18 11:13:33');
INSERT INTO `bitacora` VALUES (3347, 1, '189.129.195.84', 'Mac OS', 'Firefox', '2020-03-18 11:17:11');
INSERT INTO `bitacora` VALUES (3348, 1, '189.129.195.84', 'Mac OS', 'Firefox', '2020-03-18 11:17:45');
INSERT INTO `bitacora` VALUES (3349, 1, '189.129.195.84', 'Mac OS', 'Firefox', '2020-03-18 11:22:07');
INSERT INTO `bitacora` VALUES (3350, 1, '189.129.195.84', 'Mac OS', 'Firefox', '2020-03-18 11:24:06');
INSERT INTO `bitacora` VALUES (3351, 1, '189.129.195.84', 'Mac OS', 'Firefox', '2020-03-18 11:25:24');
INSERT INTO `bitacora` VALUES (3352, 1, '189.129.195.84', 'Mac OS', 'Firefox', '2020-03-18 11:26:59');
INSERT INTO `bitacora` VALUES (3353, 1, '189.129.195.84', 'Mac OS', 'Firefox', '2020-03-18 11:27:23');
INSERT INTO `bitacora` VALUES (3354, 1, '189.129.195.84', 'Mac OS', 'Firefox', '2020-03-18 11:32:59');
INSERT INTO `bitacora` VALUES (3355, 1, '189.129.195.84', 'Mac OS', 'Firefox', '2020-03-18 12:32:30');
INSERT INTO `bitacora` VALUES (3356, 1, '189.129.195.84', 'Mac OS', 'Firefox', '2020-03-18 13:31:35');
INSERT INTO `bitacora` VALUES (3357, 1, '189.129.195.84', 'Mac OS', 'Firefox', '2020-03-18 16:45:50');
INSERT INTO `bitacora` VALUES (3358, 1, '189.129.195.84', 'Windows', 'Google Chrome', '2020-03-18 18:16:11');
INSERT INTO `bitacora` VALUES (3359, 1, '189.253.175.242', 'Mac OS', 'Google Chrome', '2020-03-18 19:56:13');
INSERT INTO `bitacora` VALUES (3360, 1, '189.129.195.84', 'Mac OS', 'Firefox', '2020-03-19 09:39:09');
INSERT INTO `bitacora` VALUES (3361, 1, '189.129.195.84', 'Mac OS', 'Firefox', '2020-03-19 10:16:05');
INSERT INTO `bitacora` VALUES (3362, 1, '187.190.191.86', 'Windows', 'Google Chrome', '2020-03-19 10:26:46');
INSERT INTO `bitacora` VALUES (3363, 1, '187.190.191.86', 'Windows', 'Google Chrome', '2020-03-19 10:44:57');
INSERT INTO `bitacora` VALUES (3364, 1, '189.129.195.84', 'Mac OS', 'Firefox', '2020-03-19 10:48:31');
INSERT INTO `bitacora` VALUES (3365, 1, '189.129.195.84', 'Mac OS', 'Firefox', '2020-03-19 13:27:07');
INSERT INTO `bitacora` VALUES (3366, 1, '189.129.195.84', 'Mac OS', 'Firefox', '2020-03-20 11:29:30');
INSERT INTO `bitacora` VALUES (3367, 1, '189.129.195.84', 'Mac OS', 'Firefox', '2020-03-20 11:32:54');
INSERT INTO `bitacora` VALUES (3368, 1, '189.129.195.84', 'Mac OS', 'Firefox', '2020-03-20 11:48:27');
INSERT INTO `bitacora` VALUES (3369, 1, '189.129.195.84', 'Mac OS', 'Firefox', '2020-03-20 12:22:12');
INSERT INTO `bitacora` VALUES (3370, 1, '189.129.195.84', 'Mac OS', 'Firefox', '2020-03-20 13:21:06');
INSERT INTO `bitacora` VALUES (3371, 1, '189.129.195.84', 'Mac OS', 'Google Chrome', '2020-03-20 13:58:56');
INSERT INTO `bitacora` VALUES (3372, 1, '189.129.195.84', 'Mac OS', 'Firefox', '2020-03-20 15:04:03');
INSERT INTO `bitacora` VALUES (3373, 1, '189.129.195.84', 'Mac OS', 'Firefox', '2020-03-20 15:04:28');
INSERT INTO `bitacora` VALUES (3374, 1, '189.129.195.84', 'Mac OS', 'Google Chrome', '2020-03-20 20:45:29');
INSERT INTO `bitacora` VALUES (3375, 1, '177.231.232.44', 'Windows', 'Firefox', '2020-03-20 21:47:17');
INSERT INTO `bitacora` VALUES (3376, 1, '189.129.195.84', 'Mac OS', 'Google Chrome', '2020-03-20 21:56:21');
INSERT INTO `bitacora` VALUES (3377, 1, '189.253.175.242', 'Mac OS', 'Google Chrome', '2020-03-20 23:53:32');
INSERT INTO `bitacora` VALUES (3378, 1, '187.190.134.165', 'Windows', 'Google Chrome', '2020-03-21 11:46:46');
INSERT INTO `bitacora` VALUES (3379, 6, '187.190.134.165', 'Windows', 'Google Chrome', '2020-03-21 11:55:07');
INSERT INTO `bitacora` VALUES (3380, 1, '187.190.134.165', 'Windows', 'Google Chrome', '2020-03-21 11:55:32');
INSERT INTO `bitacora` VALUES (3381, 1, '187.190.134.165', 'Windows', 'Google Chrome', '2020-03-21 16:01:31');
INSERT INTO `bitacora` VALUES (3382, 1, '200.68.136.189', 'Mac OS', 'Safari', '2020-03-21 16:12:37');
INSERT INTO `bitacora` VALUES (3383, 1, '187.190.134.165', 'Windows', 'Google Chrome', '2020-03-21 16:25:49');
INSERT INTO `bitacora` VALUES (3384, 1, '187.190.134.165', 'Windows', 'Google Chrome', '2020-03-21 17:13:49');
INSERT INTO `bitacora` VALUES (3385, 1, '177.229.14.99', 'Windows', 'Google Chrome', '2020-03-23 17:24:24');
INSERT INTO `bitacora` VALUES (3386, 1, '189.129.197.94', 'Mac OS', 'Firefox', '2020-03-24 11:41:46');
INSERT INTO `bitacora` VALUES (3387, 1, '189.129.197.94', 'Mac OS', 'Firefox', '2020-03-24 11:44:19');
INSERT INTO `bitacora` VALUES (3388, 1, '177.229.14.99', 'Windows', 'Google Chrome', '2020-03-26 18:40:59');
INSERT INTO `bitacora` VALUES (3389, 1, '177.229.14.99', 'Windows', 'Google Chrome', '2020-03-26 21:51:53');
INSERT INTO `bitacora` VALUES (3390, 1, '177.229.14.99', 'Windows', 'Google Chrome', '2020-03-27 11:39:39');
INSERT INTO `bitacora` VALUES (3391, 1, '187.190.134.165', 'Windows', 'Google Chrome', '2020-03-27 16:28:25');
INSERT INTO `bitacora` VALUES (3392, 1, '200.77.64.180', 'Windows', 'Firefox', '2020-04-02 11:08:08');
INSERT INTO `bitacora` VALUES (3393, 1, '200.77.64.180', 'Windows', 'Firefox', '2020-04-02 12:23:59');
INSERT INTO `bitacora` VALUES (3394, 1, '187.190.134.165', 'Windows', 'Google Chrome', '2020-04-02 13:23:18');
INSERT INTO `bitacora` VALUES (3395, 1, '189.129.126.205', 'Mac OS', 'Google Chrome', '2020-04-02 14:30:38');
INSERT INTO `bitacora` VALUES (3396, 1, '200.77.64.180', 'Windows', 'Firefox', '2020-04-02 16:36:13');
INSERT INTO `bitacora` VALUES (3397, 1, '200.77.64.180', 'Windows', 'Firefox', '2020-04-02 16:38:37');
INSERT INTO `bitacora` VALUES (3398, 1, '189.129.126.205', 'Mac OS', 'Google Chrome', '2020-04-02 21:13:01');
INSERT INTO `bitacora` VALUES (3399, 1, '189.129.126.205', 'Mac OS', 'Google Chrome', '2020-04-03 12:44:25');
INSERT INTO `bitacora` VALUES (3400, 1, '200.77.64.180', 'Windows', 'Firefox', '2020-04-03 20:44:06');
INSERT INTO `bitacora` VALUES (3401, 1, '200.77.64.180', 'Windows', 'Firefox', '2020-04-11 14:53:55');
INSERT INTO `bitacora` VALUES (3402, 1, '200.77.64.180', 'Windows', 'Google Chrome', '2020-04-11 14:54:51');
INSERT INTO `bitacora` VALUES (3403, 1, '200.77.64.180', 'Windows', 'Firefox', '2020-04-11 15:18:11');
INSERT INTO `bitacora` VALUES (3404, 1, '200.77.64.180', 'Windows', 'Firefox', '2020-04-11 15:19:32');
INSERT INTO `bitacora` VALUES (3405, 1, '200.77.64.180', 'Windows', 'Firefox', '2020-04-11 15:22:55');
INSERT INTO `bitacora` VALUES (3406, 1, '200.77.64.180', 'Windows', 'Firefox', '2020-04-11 15:24:35');
INSERT INTO `bitacora` VALUES (3407, 1, '200.77.64.180', 'Windows', 'Firefox', '2020-04-11 15:25:00');
INSERT INTO `bitacora` VALUES (3408, 1, '200.77.64.180', 'Windows', 'Firefox', '2020-04-11 15:26:47');
INSERT INTO `bitacora` VALUES (3409, 1, '200.77.64.180', 'Windows', 'Firefox', '2020-04-11 15:36:52');
INSERT INTO `bitacora` VALUES (3410, 1, '200.77.64.180', 'Windows', 'Firefox', '2020-04-11 17:21:59');
INSERT INTO `bitacora` VALUES (3411, 1, '200.77.64.180', 'Windows', 'Firefox', '2020-04-11 20:43:25');
INSERT INTO `bitacora` VALUES (3412, 1, '177.231.226.135', 'Windows', 'Google Chrome', '2020-04-12 18:17:26');
INSERT INTO `bitacora` VALUES (3413, 1, '200.77.64.180', 'Windows', 'Firefox', '2020-04-12 18:29:20');
INSERT INTO `bitacora` VALUES (3414, 1, '200.77.64.180', 'Windows', 'Firefox', '2020-04-12 18:41:10');
INSERT INTO `bitacora` VALUES (3415, 1, '200.77.64.180', 'Windows', 'Firefox', '2020-04-12 19:21:10');
INSERT INTO `bitacora` VALUES (3416, 1, '177.231.226.135', 'Windows', 'Google Chrome', '2020-04-12 19:27:20');
INSERT INTO `bitacora` VALUES (3417, 1, '177.231.226.135', 'Windows', 'Google Chrome', '2020-04-12 20:42:09');
INSERT INTO `bitacora` VALUES (3418, 1, '200.77.64.180', 'Windows', 'Firefox', '2020-04-12 20:44:07');
INSERT INTO `bitacora` VALUES (3419, 1, '200.77.64.180', 'Windows', 'Firefox', '2020-04-12 21:34:57');
INSERT INTO `bitacora` VALUES (3420, 1, '177.231.226.135', 'Windows', 'Google Chrome', '2020-04-12 22:47:51');
INSERT INTO `bitacora` VALUES (3421, 1, '200.77.64.180', 'Windows', 'Firefox', '2020-04-12 23:18:04');
INSERT INTO `bitacora` VALUES (3422, 1, '177.231.226.135', 'Windows', 'Google Chrome', '2020-04-12 23:28:29');
INSERT INTO `bitacora` VALUES (3423, 1, '200.77.64.180', 'Windows', 'Firefox', '2020-04-12 23:31:53');
INSERT INTO `bitacora` VALUES (3424, 1, '200.77.64.180', 'Windows', 'Firefox', '2020-04-14 01:43:09');
INSERT INTO `bitacora` VALUES (3425, 1, '177.229.14.99', 'Windows', 'Google Chrome', '2020-04-17 15:28:58');
INSERT INTO `bitacora` VALUES (3426, 1, '189.129.177.100', 'Mac OS', 'Google Chrome', '2020-04-21 20:41:36');
INSERT INTO `bitacora` VALUES (3427, 1, '189.148.49.201', 'Windows', 'Google Chrome', '2020-04-21 22:48:30');
INSERT INTO `bitacora` VALUES (3428, 1, '200.77.64.180', 'Windows', 'Firefox', '2020-04-23 16:19:15');
INSERT INTO `bitacora` VALUES (3429, 1, '189.129.213.165', 'Mac OS', 'Google Chrome', '2020-04-23 17:54:19');
INSERT INTO `bitacora` VALUES (3430, 1, '189.148.12.151', 'Windows', 'Google Chrome', '2020-04-23 22:00:10');
INSERT INTO `bitacora` VALUES (3431, 1, '189.148.12.151', 'Windows', 'Google Chrome', '2020-04-23 22:30:11');
INSERT INTO `bitacora` VALUES (3432, 1, '189.148.12.151', 'Windows', 'Google Chrome', '2020-04-23 23:58:32');
INSERT INTO `bitacora` VALUES (3433, 1, '189.129.213.165', 'Mac OS', 'Google Chrome', '2020-04-23 23:59:47');
INSERT INTO `bitacora` VALUES (3434, 1, '189.148.31.144', 'Windows', 'Google Chrome', '2020-04-24 11:54:43');
INSERT INTO `bitacora` VALUES (3435, 1, '189.148.71.160', 'Windows', 'Google Chrome', '2020-04-24 17:43:09');
INSERT INTO `bitacora` VALUES (3436, 1, '::1', 'Windows 10', 'Opera', '2020-05-07 03:29:07');
INSERT INTO `bitacora` VALUES (3437, 27, '::1', 'Windows 10', 'Opera', '2020-05-07 03:49:50');
INSERT INTO `bitacora` VALUES (3438, 1, '::1', 'Windows 10', 'Opera', '2020-05-07 16:24:03');
INSERT INTO `bitacora` VALUES (3439, 1, '::1', 'Windows 10', 'Opera', '2020-05-07 16:24:52');
INSERT INTO `bitacora` VALUES (3440, 1, '::1', 'Windows 10', 'Opera', '2020-05-07 16:25:03');
INSERT INTO `bitacora` VALUES (3441, 27, '::1', 'Windows 10', 'Opera', '2020-05-07 16:25:10');
INSERT INTO `bitacora` VALUES (3442, 1, '::1', 'Windows 10', 'Opera', '2020-05-07 16:34:06');
INSERT INTO `bitacora` VALUES (3443, 1, '::1', 'Windows 10', 'Opera', '2020-05-07 16:34:21');
INSERT INTO `bitacora` VALUES (3444, 27, '::1', 'Windows 10', 'Opera', '2020-05-07 16:34:50');
INSERT INTO `bitacora` VALUES (3445, 1, '::1', 'Windows 10', 'Opera', '2020-05-07 16:36:30');
INSERT INTO `bitacora` VALUES (3446, 1, '::1', 'Windows 10', 'Opera', '2020-05-07 16:37:56');
INSERT INTO `bitacora` VALUES (3447, 28, '::1', 'Windows 10', 'Opera', '2020-05-07 16:49:10');
INSERT INTO `bitacora` VALUES (3448, 1, '::1', 'Windows 10', 'Opera', '2020-05-07 16:49:33');
INSERT INTO `bitacora` VALUES (3449, 1, '::1', 'Windows 10', 'Opera', '2020-05-08 07:29:27');
INSERT INTO `bitacora` VALUES (3450, 1, '::1', 'Windows 10', 'Opera', '2020-05-08 17:26:43');
INSERT INTO `bitacora` VALUES (3451, 1, '::1', 'Windows 10', 'Opera', '2020-05-08 17:31:37');
INSERT INTO `bitacora` VALUES (3452, 1, '::1', 'Windows 10', 'Opera', '2020-05-08 17:31:37');
INSERT INTO `bitacora` VALUES (3453, 1, '::1', 'Windows 10', 'Opera', '2020-05-08 17:57:51');
INSERT INTO `bitacora` VALUES (3454, 1, '::1', 'Windows 10', 'Opera', '2020-05-08 17:57:52');
INSERT INTO `bitacora` VALUES (3455, 1, '::1', 'Windows 10', 'Opera', '2020-05-08 18:12:41');
INSERT INTO `bitacora` VALUES (3456, 1, '::1', 'Windows 10', 'Opera', '2020-05-08 18:26:24');
INSERT INTO `bitacora` VALUES (3457, 1, '::1', 'Windows 10', 'Opera', '2020-05-08 19:49:06');
INSERT INTO `bitacora` VALUES (3458, 1, '::1', 'Windows 10', 'Opera', '2020-05-09 14:06:43');
INSERT INTO `bitacora` VALUES (3459, 1, '::1', 'Windows 10', 'Opera', '2020-05-09 18:09:30');
INSERT INTO `bitacora` VALUES (3460, 1, '::1', 'Windows 10', 'Opera', '2020-05-09 19:25:26');
INSERT INTO `bitacora` VALUES (3461, 1, '::1', 'Windows 10', 'Opera', '2020-05-09 19:25:35');
INSERT INTO `bitacora` VALUES (3462, 1, '::1', 'Windows 10', 'Opera', '2020-05-09 19:25:51');
INSERT INTO `bitacora` VALUES (3463, 1, '::1', 'Windows 10', 'Opera', '2020-05-09 19:26:07');
INSERT INTO `bitacora` VALUES (3464, 1, '::1', 'Windows 10', 'Opera', '2020-05-09 19:26:35');
INSERT INTO `bitacora` VALUES (3465, 1, '::1', 'Windows 10', 'Opera', '2020-05-09 22:19:33');
INSERT INTO `bitacora` VALUES (3466, 1, '::1', 'Windows 10', 'Opera', '2020-05-10 00:01:53');
INSERT INTO `bitacora` VALUES (3467, 1, '::1', 'Windows 10', 'Opera', '2020-05-10 05:51:47');
INSERT INTO `bitacora` VALUES (3468, 1, '::1', 'Windows 10', 'Opera', '2020-05-10 12:34:19');
INSERT INTO `bitacora` VALUES (3469, 1, '::1', 'Windows 10', 'Opera', '2020-05-11 22:35:41');
INSERT INTO `bitacora` VALUES (3470, 1, '::1', 'Windows 10', 'Opera', '2020-05-12 00:05:16');
INSERT INTO `bitacora` VALUES (3471, 1, '::1', 'Windows 10', 'Opera', '2020-05-12 03:34:39');
INSERT INTO `bitacora` VALUES (3472, 1, '::1', 'Windows 10', 'Opera', '2020-05-12 12:56:15');
INSERT INTO `bitacora` VALUES (3473, 1, '::1', 'Windows 10', 'Opera', '2020-05-12 13:11:10');
INSERT INTO `bitacora` VALUES (3474, 1, '::1', 'Windows 10', 'Opera', '2020-05-12 19:00:51');
INSERT INTO `bitacora` VALUES (3475, 1, '::1', 'Windows 10', 'Opera', '2020-05-13 02:32:02');
INSERT INTO `bitacora` VALUES (3476, 1, '::1', 'Windows 10', 'Opera', '2020-05-13 17:48:41');
INSERT INTO `bitacora` VALUES (3477, 1, '::1', 'Windows 10', 'Opera', '2020-05-13 22:53:52');
INSERT INTO `bitacora` VALUES (3478, 1, '::1', 'Windows 10', 'Opera', '2020-05-14 02:27:39');
INSERT INTO `bitacora` VALUES (3479, 1, '::1', 'Windows 10', 'Opera', '2020-05-14 13:02:08');
INSERT INTO `bitacora` VALUES (3480, 1, '::1', 'Windows 10', 'Opera', '2020-05-14 14:10:36');
INSERT INTO `bitacora` VALUES (3481, 1, '::1', 'Windows 10', 'Opera', '2020-05-14 19:29:50');
INSERT INTO `bitacora` VALUES (3482, 1, '192.168.1.74', 'Android', 'Chrome', '2020-05-15 02:11:37');
INSERT INTO `bitacora` VALUES (3483, 1, '::1', 'Windows 10', 'Opera', '2020-05-15 14:53:00');
INSERT INTO `bitacora` VALUES (3484, 1, '::1', 'Windows 10', 'Opera', '2020-05-17 04:10:47');
INSERT INTO `bitacora` VALUES (3485, 1, '::1', 'Windows 10', 'Opera', '2020-05-18 02:29:56');
INSERT INTO `bitacora` VALUES (3486, 1, '::1', 'Windows 10', 'Opera', '2020-05-19 07:21:27');
INSERT INTO `bitacora` VALUES (3487, 1, '::1', 'Windows 10', 'Opera', '2020-05-19 23:22:21');
INSERT INTO `bitacora` VALUES (3488, 1, '::1', 'Windows 10', 'Opera', '2020-05-20 05:28:37');
INSERT INTO `bitacora` VALUES (3489, 1, '::1', 'Windows 10', 'Opera', '2020-05-20 12:54:09');
INSERT INTO `bitacora` VALUES (3490, 1, '::1', 'Windows 10', 'Opera', '2020-05-21 04:29:33');
INSERT INTO `bitacora` VALUES (3491, 1, '::1', 'Windows 10', 'Opera', '2020-05-22 15:36:00');
INSERT INTO `bitacora` VALUES (3492, 30, '::1', 'Windows 10', 'Opera', '2020-05-22 15:38:57');
INSERT INTO `bitacora` VALUES (3493, 1, '::1', 'Windows 10', 'Opera', '2020-05-22 15:39:34');
INSERT INTO `bitacora` VALUES (3494, 1, '::1', 'Windows 10', 'Opera', '2020-05-23 08:26:05');
INSERT INTO `bitacora` VALUES (3495, 1, '::1', 'Windows 10', 'Opera', '2020-06-11 03:23:25');
INSERT INTO `bitacora` VALUES (3496, 1, '::1', 'Windows 10', 'Opera', '2020-06-11 18:41:16');
INSERT INTO `bitacora` VALUES (3497, 1, '::1', 'Windows 10', 'Opera', '2020-06-11 21:21:26');
INSERT INTO `bitacora` VALUES (3498, 1, '::1', 'Windows 10', 'Opera', '2020-06-11 21:21:38');
INSERT INTO `bitacora` VALUES (3499, 1, '::1', 'Windows 10', 'Opera', '2020-06-11 21:30:52');
INSERT INTO `bitacora` VALUES (3500, 1, '::1', 'Windows 10', 'Opera', '2020-06-12 18:57:55');
INSERT INTO `bitacora` VALUES (3501, 1, '::1', 'Windows 10', 'Opera', '2020-06-13 11:22:38');
INSERT INTO `bitacora` VALUES (3502, 1, '::1', 'Windows 10', 'Opera', '2020-07-01 00:58:29');
INSERT INTO `bitacora` VALUES (3503, 1, '::1', 'Windows 10', 'Opera', '2020-07-01 23:09:18');
INSERT INTO `bitacora` VALUES (3504, 1, '::1', 'Windows 10', 'Opera', '2020-07-01 23:16:03');
INSERT INTO `bitacora` VALUES (3505, 1, '::1', 'Windows 10', 'Opera', '2020-07-01 23:16:18');
INSERT INTO `bitacora` VALUES (3506, 1, '::1', 'Windows 10', 'Opera', '2020-07-02 00:46:31');
INSERT INTO `bitacora` VALUES (3507, 1, '::1', 'Windows 10', 'Opera', '2020-07-02 15:07:14');
INSERT INTO `bitacora` VALUES (3508, 1, '::1', 'Windows 10', 'Opera', '2020-07-02 16:30:56');
INSERT INTO `bitacora` VALUES (3509, 1, '::1', 'Windows 10', 'Opera', '2020-07-07 00:01:32');
INSERT INTO `bitacora` VALUES (3510, 1, '::1', 'Windows 10', 'Opera', '2020-07-31 17:07:25');
INSERT INTO `bitacora` VALUES (3511, 1, '::1', 'Windows 10', 'Opera', '2020-07-31 17:11:18');
INSERT INTO `bitacora` VALUES (3512, 1, '::1', 'Windows 10', 'Opera', '2020-07-31 17:23:44');
INSERT INTO `bitacora` VALUES (3513, 1, '::1', 'Windows 10', 'Opera', '2020-10-15 23:09:37');
INSERT INTO `bitacora` VALUES (3514, 1, '::1', 'Windows 10', 'Opera', '2020-10-23 20:21:52');
INSERT INTO `bitacora` VALUES (3515, 1, '::1', 'Windows 10', 'Opera', '2020-11-17 01:02:21');
INSERT INTO `bitacora` VALUES (3516, 1, '::1', 'Windows 10', 'Opera', '2020-11-17 01:20:52');
INSERT INTO `bitacora` VALUES (3517, 1, '::1', 'Windows 10', 'Opera', '2020-11-17 09:42:11');
INSERT INTO `bitacora` VALUES (3518, 1, '::1', 'Windows 10', 'Opera', '2020-11-17 09:55:26');
INSERT INTO `bitacora` VALUES (3519, 1, '::1', 'Windows 10', 'Opera', '2020-11-17 15:16:51');
INSERT INTO `bitacora` VALUES (3520, 1, '::1', 'Windows 10', 'Opera', '2020-11-17 16:49:44');
INSERT INTO `bitacora` VALUES (3521, 1, '::1', 'Windows 10', 'Opera', '2020-11-17 19:01:55');
INSERT INTO `bitacora` VALUES (3522, 1, '::1', 'Windows 10', 'Opera', '2020-11-18 14:12:12');
INSERT INTO `bitacora` VALUES (3523, 1, '::1', 'Windows 10', 'Opera', '2020-11-18 14:12:31');
INSERT INTO `bitacora` VALUES (3524, 1, '::1', 'Windows 10', 'Opera', '2020-11-18 14:12:52');
INSERT INTO `bitacora` VALUES (3525, 1, '::1', 'Windows 10', 'Opera', '2020-11-18 14:21:09');
INSERT INTO `bitacora` VALUES (3526, 1, '::1', 'Windows 10', 'Opera', '2020-11-18 14:34:48');

-- ----------------------------
-- Table structure for bitacora_movimientos
-- ----------------------------
DROP TABLE IF EXISTS `bitacora_movimientos`;
CREATE TABLE `bitacora_movimientos`  (
  `idbitacora_movimientos` int(11) NOT NULL AUTO_INCREMENT,
  `idbitacora` int(11) NOT NULL,
  `modulo` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `descripcion` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `fecha_movimiento` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`idbitacora_movimientos`) USING BTREE,
  INDEX `fk_bitacora_movimientos_bitacora1`(`idbitacora`) USING BTREE,
  CONSTRAINT `bitacora_movimientos_ibfk_1` FOREIGN KEY (`idbitacora`) REFERENCES `bitacora` (`idbitacora`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 11090 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of bitacora_movimientos
-- ----------------------------
INSERT INTO `bitacora_movimientos` VALUES (10084, 3255, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-01-31 13:09:47');
INSERT INTO `bitacora_movimientos` VALUES (10085, 3256, 'Catalogos', 'Nueva Categoria de precio creada con el ID :7', '2020-02-06 18:11:13');
INSERT INTO `bitacora_movimientos` VALUES (10086, 3257, 'Nivel', 'Nueva Nivel creado con el ID :7', '2020-02-06 18:11:18');
INSERT INTO `bitacora_movimientos` VALUES (10087, 3256, 'Catalogos', 'Nueva Categoria de precio creada con el ID :8', '2020-02-06 18:11:28');
INSERT INTO `bitacora_movimientos` VALUES (10088, 3258, 'Nivel', 'Nueva Nivel creado con el ID :8', '2020-02-06 18:11:46');
INSERT INTO `bitacora_movimientos` VALUES (10089, 3257, 'Nivel', 'Nueva Nivel creado con el ID :9', '2020-02-06 18:12:09');
INSERT INTO `bitacora_movimientos` VALUES (10090, 3256, 'Catalogos', 'Nueva Categoria de precio creada con el ID :9', '2020-02-06 18:12:18');
INSERT INTO `bitacora_movimientos` VALUES (10091, 3257, 'niveles', 'Modificamos Nivel con el ID :8', '2020-02-06 18:12:30');
INSERT INTO `bitacora_movimientos` VALUES (10092, 3257, 'niveles', 'Modificamos Nivel con el ID :7', '2020-02-06 18:12:40');
INSERT INTO `bitacora_movimientos` VALUES (10093, 3257, 'niveles', 'Modificamos Nivel con el ID :9', '2020-02-06 18:12:55');
INSERT INTO `bitacora_movimientos` VALUES (10094, 3257, 'Catalogos', 'Nueva Categoria de precio por nivel creada con el ID :0', '2020-02-06 18:13:10');
INSERT INTO `bitacora_movimientos` VALUES (10095, 3257, 'Catalogos', 'Nueva Categoria de precio por nivel creada con el ID :0', '2020-02-06 18:13:20');
INSERT INTO `bitacora_movimientos` VALUES (10096, 3257, 'Catalogos', 'Nueva Categoria de precio por nivel creada con el ID :0', '2020-02-06 18:13:36');
INSERT INTO `bitacora_movimientos` VALUES (10097, 3257, 'Catalogos', 'Nueva Categoria de precio por nivel creada con el ID :0', '2020-02-06 18:13:48');
INSERT INTO `bitacora_movimientos` VALUES (10098, 3257, 'Catalogos', 'Nueva Categoria de precio por nivel creada con el ID :0', '2020-02-06 18:14:03');
INSERT INTO `bitacora_movimientos` VALUES (10099, 3257, 'Catalogos', 'Nueva Categoria de precio por nivel creada con el ID :0', '2020-02-06 18:14:14');
INSERT INTO `bitacora_movimientos` VALUES (10100, 3257, 'Catalogos', 'Nueva Categoria de precio por nivel creada con el ID :0', '2020-02-06 18:14:26');
INSERT INTO `bitacora_movimientos` VALUES (10101, 3256, 'Clientes', 'Nuevo Cliente creado con el ID :4113', '2020-02-06 18:16:03');
INSERT INTO `bitacora_movimientos` VALUES (10102, 3257, 'Clientes', 'Nuevo Cliente creado con el ID :4114', '2020-02-06 18:17:20');
INSERT INTO `bitacora_movimientos` VALUES (10103, 3258, 'Clientes', 'Nuevo Cliente creado con el ID :4115', '2020-02-06 18:18:08');
INSERT INTO `bitacora_movimientos` VALUES (10104, 3256, 'paqueterias', 'Nueva paqueteria creado con el ID :4', '2020-02-06 18:20:53');
INSERT INTO `bitacora_movimientos` VALUES (10105, 3257, 'paqueterias', 'Nueva paqueteria creado con el ID :5', '2020-02-06 18:20:59');
INSERT INTO `bitacora_movimientos` VALUES (10106, 3256, 'paqueterias', 'Modificacion de paqueteria con el ID :4', '2020-02-06 18:21:47');
INSERT INTO `bitacora_movimientos` VALUES (10107, 3257, 'Categorias', 'Nueva Categoria con el ID :12', '2020-02-06 18:21:59');
INSERT INTO `bitacora_movimientos` VALUES (10108, 3257, 'Categorias', 'Nueva Categoria con el ID :13', '2020-02-06 18:22:20');
INSERT INTO `bitacora_movimientos` VALUES (10109, 3258, 'paqueterias', 'Nueva paqueteria creado con el ID :6', '2020-02-06 18:22:22');
INSERT INTO `bitacora_movimientos` VALUES (10110, 3257, 'Categorias', 'Nueva Categoria con el ID :14', '2020-02-06 18:22:35');
INSERT INTO `bitacora_movimientos` VALUES (10111, 3256, 'paqueterias', 'Modificacion de paqueteria con el ID :4', '2020-02-06 18:22:36');
INSERT INTO `bitacora_movimientos` VALUES (10112, 3257, 'Categorias', 'Modificamos la Categoría con el ID :14', '2020-02-06 18:22:43');
INSERT INTO `bitacora_movimientos` VALUES (10113, 3257, 'Categorias', 'Modificamos la Categoría con el ID :12', '2020-02-06 18:22:49');
INSERT INTO `bitacora_movimientos` VALUES (10114, 3257, 'Categorias', 'Nueva Categoria con el ID :15', '2020-02-06 18:23:04');
INSERT INTO `bitacora_movimientos` VALUES (10115, 3256, 'Categorias', 'Modificamos Categorias precio con el ID :7', '2020-02-06 18:24:09');
INSERT INTO `bitacora_movimientos` VALUES (10116, 3256, 'Categorias', 'Modificamos Categorias precio con el ID :8', '2020-02-06 18:24:20');
INSERT INTO `bitacora_movimientos` VALUES (10117, 3256, 'Categorias', 'Modificamos Categorias precio con el ID :9', '2020-02-06 18:24:32');
INSERT INTO `bitacora_movimientos` VALUES (10118, 3257, 'Tallas', 'Nueva Talla con el ID :28', '2020-02-06 18:27:57');
INSERT INTO `bitacora_movimientos` VALUES (10119, 3256, 'Tallas', 'Nueva Talla con el ID :29', '2020-02-06 18:28:02');
INSERT INTO `bitacora_movimientos` VALUES (10120, 3256, 'Tallas', 'Nueva Talla con el ID :30', '2020-02-06 18:28:14');
INSERT INTO `bitacora_movimientos` VALUES (10121, 3257, 'Tallas', 'Nueva Talla con el ID :31', '2020-02-06 18:28:15');
INSERT INTO `bitacora_movimientos` VALUES (10122, 3257, 'Tallas', 'Modificamos la talla con el ID :29', '2020-02-06 18:28:27');
INSERT INTO `bitacora_movimientos` VALUES (10123, 3256, 'Tallas', 'Modificamos la talla con el ID :29', '2020-02-06 18:28:28');
INSERT INTO `bitacora_movimientos` VALUES (10124, 3256, 'Tallas', 'Modificamos la talla con el ID :30', '2020-02-06 18:28:37');
INSERT INTO `bitacora_movimientos` VALUES (10125, 3257, 'Tallas', 'Modificamos la talla con el ID :29', '2020-02-06 18:28:37');
INSERT INTO `bitacora_movimientos` VALUES (10126, 3258, 'Productos', 'Nuevo producto con el ID :c201', '2020-02-06 18:30:36');
INSERT INTO `bitacora_movimientos` VALUES (10127, 3258, 'Tallas', 'Nueva Talla con el ID :32', '2020-02-06 18:31:12');
INSERT INTO `bitacora_movimientos` VALUES (10128, 3257, 'Productos', 'Nuevo producto con el ID :V001', '2020-02-06 18:31:33');
INSERT INTO `bitacora_movimientos` VALUES (10129, 3258, 'Tallas', 'Modificamos la talla con el ID :32', '2020-02-06 18:31:33');
INSERT INTO `bitacora_movimientos` VALUES (10130, 3258, 'Tallas', 'Nueva Talla con el ID :33', '2020-02-06 18:31:55');
INSERT INTO `bitacora_movimientos` VALUES (10131, 3256, 'Productos', 'Nuevo producto con el ID :RP01', '2020-02-06 18:31:58');
INSERT INTO `bitacora_movimientos` VALUES (10132, 3258, 'Tallas', 'Nueva Talla con el ID :34', '2020-02-06 18:32:16');
INSERT INTO `bitacora_movimientos` VALUES (10133, 3256, 'Productos', 'Modificamos el producto con el ID :c201', '2020-02-06 18:32:34');
INSERT INTO `bitacora_movimientos` VALUES (10134, 3257, 'productos_imagenes', 'Guardando foto del producto con ID:-V001 y el registro con ID:-1', '2020-02-06 18:32:50');
INSERT INTO `bitacora_movimientos` VALUES (10135, 3257, 'productos_imagenes', 'Guardando foto del producto con ID:-V001 y el registro con ID:-2', '2020-02-06 18:33:02');
INSERT INTO `bitacora_movimientos` VALUES (10136, 3257, 'productos_imagenes', 'Guardando foto del producto con ID:-V001 y el registro con ID:-3', '2020-02-06 18:33:15');
INSERT INTO `bitacora_movimientos` VALUES (10137, 3256, 'Productos', 'Nuevo producto con el ID :RP02', '2020-02-06 18:33:24');
INSERT INTO `bitacora_movimientos` VALUES (10138, 3257, 'productos_imagenes', 'Guardando foto del producto con ID:-V001 y el registro con ID:-4', '2020-02-06 18:33:27');
INSERT INTO `bitacora_movimientos` VALUES (10139, 3256, 'Productos', 'Modificamos el producto con el ID :RP02', '2020-02-06 18:33:39');
INSERT INTO `bitacora_movimientos` VALUES (10140, 3257, 'productos_imagenes', 'Guardando foto del producto con ID:-V001 y el registro con ID:-5', '2020-02-06 18:33:40');
INSERT INTO `bitacora_movimientos` VALUES (10141, 3257, 'productos_imagenes', 'Se elimino el Id :4', '2020-02-06 18:33:44');
INSERT INTO `bitacora_movimientos` VALUES (10142, 3256, 'Productos', 'Nuevo producto con el ID :RP03', '2020-02-06 18:34:45');
INSERT INTO `bitacora_movimientos` VALUES (10143, 3257, 'Productos', 'Nuevo producto con el ID :V002', '2020-02-06 18:36:03');
INSERT INTO `bitacora_movimientos` VALUES (10144, 3258, 'Productos', 'Modificamos el producto con el ID :c201', '2020-02-06 18:36:21');
INSERT INTO `bitacora_movimientos` VALUES (10145, 3257, 'productos_imagenes', 'Guardando foto del producto con ID:-V002 y el registro con ID:-6', '2020-02-06 18:36:53');
INSERT INTO `bitacora_movimientos` VALUES (10146, 3258, 'Tallas', 'Nueva Talla con el ID :35', '2020-02-06 18:37:02');
INSERT INTO `bitacora_movimientos` VALUES (10147, 3257, 'productos_imagenes', 'Guardando foto del producto con ID:-V002 y el registro con ID:-7', '2020-02-06 18:37:03');
INSERT INTO `bitacora_movimientos` VALUES (10148, 3257, 'productos_imagenes', 'Guardando foto del producto con ID:-V002 y el registro con ID:-8', '2020-02-06 18:37:13');
INSERT INTO `bitacora_movimientos` VALUES (10149, 3257, 'productos_imagenes', 'Guardando foto del producto con ID:-V002 y el registro con ID:-9', '2020-02-06 18:37:24');
INSERT INTO `bitacora_movimientos` VALUES (10150, 3256, 'productos_imagenes', 'Guardando foto del producto con ID:-RP01 y el registro con ID:-10', '2020-02-06 18:37:30');
INSERT INTO `bitacora_movimientos` VALUES (10151, 3256, 'productos_imagenes', 'Modificamos datos de foto del producto-RP01 y el registro con ID:-10', '2020-02-06 18:38:00');
INSERT INTO `bitacora_movimientos` VALUES (10152, 3256, 'Productos', 'Modificamos el producto con el ID :RP02', '2020-02-06 18:39:54');
INSERT INTO `bitacora_movimientos` VALUES (10153, 3257, 'Productos', 'Nuevo producto con el ID :V003', '2020-02-06 18:39:56');
INSERT INTO `bitacora_movimientos` VALUES (10154, 3256, 'productos_imagenes', 'Guardando foto del producto con ID:-RP02 y el registro con ID:-11', '2020-02-06 18:40:16');
INSERT INTO `bitacora_movimientos` VALUES (10155, 3257, 'productos_imagenes', 'Guardando foto del producto con ID:-V003 y el registro con ID:-12', '2020-02-06 18:40:27');
INSERT INTO `bitacora_movimientos` VALUES (10156, 3257, 'productos_imagenes', 'Guardando foto del producto con ID:-V003 y el registro con ID:-13', '2020-02-06 18:40:40');
INSERT INTO `bitacora_movimientos` VALUES (10157, 3256, 'Productos', 'Modificamos el producto con el ID :RP02', '2020-02-06 18:40:45');
INSERT INTO `bitacora_movimientos` VALUES (10158, 3257, 'productos_imagenes', 'Guardando foto del producto con ID:-V003 y el registro con ID:-14', '2020-02-06 18:40:51');
INSERT INTO `bitacora_movimientos` VALUES (10159, 3257, 'productos_imagenes', 'Guardando foto del producto con ID:-V003 y el registro con ID:-15', '2020-02-06 18:41:02');
INSERT INTO `bitacora_movimientos` VALUES (10160, 3258, 'Productos', 'Nuevo producto con el ID :c202', '2020-02-06 18:42:59');
INSERT INTO `bitacora_movimientos` VALUES (10161, 3256, 'Productos', 'Modificamos el producto con el ID :RP03', '2020-02-06 18:43:32');
INSERT INTO `bitacora_movimientos` VALUES (10162, 3256, 'productos_imagenes', 'Guardando foto del producto con ID:-RP03 y el registro con ID:-16', '2020-02-06 18:44:13');
INSERT INTO `bitacora_movimientos` VALUES (10163, 3258, 'Productos', 'Nuevo producto con el ID :c203', '2020-02-06 18:47:54');
INSERT INTO `bitacora_movimientos` VALUES (10164, 3258, 'productos_imagenes', 'Guardando foto del producto con ID:-c203 y el registro con ID:-17', '2020-02-06 18:50:58');
INSERT INTO `bitacora_movimientos` VALUES (10165, 3258, 'productos_imagenes', 'Guardando foto del producto con ID:-c203 y el registro con ID:-18', '2020-02-06 18:51:28');
INSERT INTO `bitacora_movimientos` VALUES (10166, 3258, 'productos_imagenes', 'Guardando foto del producto con ID:-c202 y el registro con ID:-19', '2020-02-06 18:52:00');
INSERT INTO `bitacora_movimientos` VALUES (10167, 3258, 'productos_imagenes', 'Guardando foto del producto con ID:-c202 y el registro con ID:-20', '2020-02-06 18:52:22');
INSERT INTO `bitacora_movimientos` VALUES (10168, 3258, 'productos_imagenes', 'Guardando foto del producto con ID:-c201 y el registro con ID:-21', '2020-02-06 18:53:36');
INSERT INTO `bitacora_movimientos` VALUES (10169, 3258, 'productos_imagenes', 'Guardando foto del producto con ID:-c201 y el registro con ID:-22', '2020-02-06 18:53:48');
INSERT INTO `bitacora_movimientos` VALUES (10170, 3258, 'Productos', 'Modificamos el producto con el ID :c201', '2020-02-06 18:57:24');
INSERT INTO `bitacora_movimientos` VALUES (10171, 3258, 'Productos', 'Modificamos el producto con el ID :c202', '2020-02-06 18:57:46');
INSERT INTO `bitacora_movimientos` VALUES (10172, 3258, 'Productos', 'Modificamos el producto con el ID :c203', '2020-02-06 18:58:01');
INSERT INTO `bitacora_movimientos` VALUES (10173, 3258, 'Productos', 'Modificamos el producto con el ID :c203', '2020-02-06 18:58:25');
INSERT INTO `bitacora_movimientos` VALUES (10174, 3258, 'Productos', 'Modificamos el producto con el ID :c202', '2020-02-06 18:58:42');
INSERT INTO `bitacora_movimientos` VALUES (10175, 3258, 'Productos', 'Modificamos el producto con el ID :c201', '2020-02-06 18:59:02');
INSERT INTO `bitacora_movimientos` VALUES (10176, 3256, 'entradas', 'Nueva entrada con el ID :494', '2020-02-06 19:15:41');
INSERT INTO `bitacora_movimientos` VALUES (10177, 3256, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :494 IDproducto: RP01', '2020-02-06 19:15:41');
INSERT INTO `bitacora_movimientos` VALUES (10178, 3258, 'Productos', 'Modificamos el producto con el ID :c201', '2020-02-06 19:15:48');
INSERT INTO `bitacora_movimientos` VALUES (10180, 3257, 'entradas', 'Nueva entrada con el ID :496', '2020-02-06 19:18:17');
INSERT INTO `bitacora_movimientos` VALUES (10181, 3257, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :496 IDproducto: V001', '2020-02-06 19:18:17');
INSERT INTO `bitacora_movimientos` VALUES (10182, 3257, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :496 IDproducto: V002', '2020-02-06 19:18:17');
INSERT INTO `bitacora_movimientos` VALUES (10183, 3257, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :496 IDproducto: V003', '2020-02-06 19:18:17');
INSERT INTO `bitacora_movimientos` VALUES (10184, 3257, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :496 IDproducto: V001', '2020-02-06 19:18:17');
INSERT INTO `bitacora_movimientos` VALUES (10185, 3257, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :496 IDproducto: V002', '2020-02-06 19:18:17');
INSERT INTO `bitacora_movimientos` VALUES (10186, 3257, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :496 IDproducto: V003', '2020-02-06 19:18:17');
INSERT INTO `bitacora_movimientos` VALUES (10187, 3257, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :496 IDproducto: V003', '2020-02-06 19:18:17');
INSERT INTO `bitacora_movimientos` VALUES (10190, 3256, 'entradas', 'Nueva entrada con el ID :499', '2020-02-06 19:21:04');
INSERT INTO `bitacora_movimientos` VALUES (10191, 3256, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :499 IDproducto: RP01', '2020-02-06 19:21:04');
INSERT INTO `bitacora_movimientos` VALUES (10192, 3256, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :499 IDproducto: RP03', '2020-02-06 19:21:04');
INSERT INTO `bitacora_movimientos` VALUES (10193, 3256, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :499 IDproducto: RP02', '2020-02-06 19:21:04');
INSERT INTO `bitacora_movimientos` VALUES (10194, 3257, 'entradas', 'Nueva entrada con el ID :500', '2020-02-06 19:21:21');
INSERT INTO `bitacora_movimientos` VALUES (10195, 3257, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :500 IDproducto: C201', '2020-02-06 19:21:21');
INSERT INTO `bitacora_movimientos` VALUES (10196, 3257, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :500 IDproducto: C201', '2020-02-06 19:21:21');
INSERT INTO `bitacora_movimientos` VALUES (10197, 3257, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :500 IDproducto: C201', '2020-02-06 19:21:21');
INSERT INTO `bitacora_movimientos` VALUES (10198, 3257, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :500 IDproducto: C202', '2020-02-06 19:21:21');
INSERT INTO `bitacora_movimientos` VALUES (10199, 3257, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :500 IDproducto: C203', '2020-02-06 19:21:21');
INSERT INTO `bitacora_movimientos` VALUES (10200, 3257, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :500 IDproducto: C203', '2020-02-06 19:21:21');
INSERT INTO `bitacora_movimientos` VALUES (10201, 3257, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :500 IDproducto: C202', '2020-02-06 19:21:21');
INSERT INTO `bitacora_movimientos` VALUES (10202, 3257, 'etiqueta', 'Nueva Lista de etiqetas con el id :2', '2020-02-06 19:23:54');
INSERT INTO `bitacora_movimientos` VALUES (10203, 3256, 'etiqueta', 'Nueva Lista de etiqetas con el id :3', '2020-02-06 19:25:36');
INSERT INTO `bitacora_movimientos` VALUES (10204, 3258, 'etiqueta', 'Nueva Lista de etiqetas con el id :4', '2020-02-06 19:25:44');
INSERT INTO `bitacora_movimientos` VALUES (10205, 3257, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :2 IDproducto: 1', '2020-02-06 19:26:04');
INSERT INTO `bitacora_movimientos` VALUES (10206, 3257, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :2 IDproducto: 2', '2020-02-06 19:26:04');
INSERT INTO `bitacora_movimientos` VALUES (10207, 3257, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :2 IDproducto: 3', '2020-02-06 19:26:04');
INSERT INTO `bitacora_movimientos` VALUES (10208, 3257, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :2 IDproducto: 4', '2020-02-06 19:26:04');
INSERT INTO `bitacora_movimientos` VALUES (10209, 3257, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :2 IDproducto: 5', '2020-02-06 19:26:04');
INSERT INTO `bitacora_movimientos` VALUES (10210, 3257, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :2 IDproducto: 6', '2020-02-06 19:26:04');
INSERT INTO `bitacora_movimientos` VALUES (10211, 3257, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :2 IDproducto: 7', '2020-02-06 19:26:04');
INSERT INTO `bitacora_movimientos` VALUES (10212, 3257, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :2 IDproducto: 8', '2020-02-06 19:26:04');
INSERT INTO `bitacora_movimientos` VALUES (10213, 3257, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :2 IDproducto: 9', '2020-02-06 19:26:04');
INSERT INTO `bitacora_movimientos` VALUES (10214, 3257, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :2 IDproducto: 10', '2020-02-06 19:26:04');
INSERT INTO `bitacora_movimientos` VALUES (10215, 3257, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :2 IDproducto: 11', '2020-02-06 19:26:04');
INSERT INTO `bitacora_movimientos` VALUES (10216, 3257, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :2 IDproducto: 12', '2020-02-06 19:26:04');
INSERT INTO `bitacora_movimientos` VALUES (10217, 3257, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :2 IDproducto: 13', '2020-02-06 19:26:04');
INSERT INTO `bitacora_movimientos` VALUES (10218, 3257, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :2 IDproducto: 14', '2020-02-06 19:26:04');
INSERT INTO `bitacora_movimientos` VALUES (10219, 3257, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :2 IDproducto: 15', '2020-02-06 19:26:04');
INSERT INTO `bitacora_movimientos` VALUES (10220, 3256, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :3 IDproducto: 1', '2020-02-06 19:26:13');
INSERT INTO `bitacora_movimientos` VALUES (10221, 3256, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :3 IDproducto: 2', '2020-02-06 19:26:13');
INSERT INTO `bitacora_movimientos` VALUES (10222, 3256, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :3 IDproducto: 3', '2020-02-06 19:26:13');
INSERT INTO `bitacora_movimientos` VALUES (10223, 3256, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :3 IDproducto: 4', '2020-02-06 19:26:13');
INSERT INTO `bitacora_movimientos` VALUES (10224, 3256, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :3 IDproducto: 5', '2020-02-06 19:26:13');
INSERT INTO `bitacora_movimientos` VALUES (10225, 3256, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :3 IDproducto: 6', '2020-02-06 19:26:13');
INSERT INTO `bitacora_movimientos` VALUES (10226, 3256, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :3 IDproducto: 1', '2020-02-06 19:26:40');
INSERT INTO `bitacora_movimientos` VALUES (10227, 3256, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :3 IDproducto: 2', '2020-02-06 19:26:40');
INSERT INTO `bitacora_movimientos` VALUES (10228, 3256, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :3 IDproducto: 3', '2020-02-06 19:26:40');
INSERT INTO `bitacora_movimientos` VALUES (10229, 3256, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :3 IDproducto: 4', '2020-02-06 19:26:40');
INSERT INTO `bitacora_movimientos` VALUES (10230, 3258, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :4 IDproducto: 1', '2020-02-06 19:27:04');
INSERT INTO `bitacora_movimientos` VALUES (10231, 3258, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :4 IDproducto: 2', '2020-02-06 19:27:04');
INSERT INTO `bitacora_movimientos` VALUES (10232, 3257, 'Productos', 'Modificamos el producto con el ID :V001', '2020-02-06 19:27:12');
INSERT INTO `bitacora_movimientos` VALUES (10233, 3256, 'etiquetas', 'Se elimino el Id :2', '2020-02-06 19:27:18');
INSERT INTO `bitacora_movimientos` VALUES (10234, 3257, 'Productos', 'Modificamos el producto con el ID :V003', '2020-02-06 19:27:47');
INSERT INTO `bitacora_movimientos` VALUES (10235, 3257, 'Productos', 'Modificamos el producto con el ID :V003', '2020-02-06 19:28:03');
INSERT INTO `bitacora_movimientos` VALUES (10236, 3257, 'etiqueta', 'Nueva Lista de etiqetas con el id :5', '2020-02-06 19:28:13');
INSERT INTO `bitacora_movimientos` VALUES (10237, 3258, 'etiqueta', 'Nueva Lista de etiqetas con el id :6', '2020-02-06 19:28:34');
INSERT INTO `bitacora_movimientos` VALUES (10238, 3258, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :4 IDproducto: 1', '2020-02-06 19:29:04');
INSERT INTO `bitacora_movimientos` VALUES (10239, 3258, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :4 IDproducto: 2', '2020-02-06 19:29:04');
INSERT INTO `bitacora_movimientos` VALUES (10240, 3258, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :4 IDproducto: 3', '2020-02-06 19:29:04');
INSERT INTO `bitacora_movimientos` VALUES (10241, 3258, 'etiqueta', 'Nueva Lista de etiqetas con el id :7', '2020-02-06 19:29:27');
INSERT INTO `bitacora_movimientos` VALUES (10242, 3257, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :5 IDproducto: 1', '2020-02-06 19:29:31');
INSERT INTO `bitacora_movimientos` VALUES (10243, 3257, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :5 IDproducto: 2', '2020-02-06 19:29:31');
INSERT INTO `bitacora_movimientos` VALUES (10244, 3257, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :5 IDproducto: 3', '2020-02-06 19:29:31');
INSERT INTO `bitacora_movimientos` VALUES (10245, 3257, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :5 IDproducto: 4', '2020-02-06 19:29:31');
INSERT INTO `bitacora_movimientos` VALUES (10246, 3257, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :5 IDproducto: 5', '2020-02-06 19:29:31');
INSERT INTO `bitacora_movimientos` VALUES (10247, 3257, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :5 IDproducto: 6', '2020-02-06 19:29:31');
INSERT INTO `bitacora_movimientos` VALUES (10248, 3257, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :5 IDproducto: 7', '2020-02-06 19:29:31');
INSERT INTO `bitacora_movimientos` VALUES (10249, 3257, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :5 IDproducto: 8', '2020-02-06 19:29:31');
INSERT INTO `bitacora_movimientos` VALUES (10250, 3257, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :5 IDproducto: 9', '2020-02-06 19:29:31');
INSERT INTO `bitacora_movimientos` VALUES (10251, 3257, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :5 IDproducto: 10', '2020-02-06 19:29:31');
INSERT INTO `bitacora_movimientos` VALUES (10252, 3257, 'Nota Descripcion', 'Agregamos los detalles de la Nota de remsion:2814', '2020-02-06 19:31:13');
INSERT INTO `bitacora_movimientos` VALUES (10253, 3257, 'Nota Descripcion', 'Agregamos los detalles de la Nota de remsion:2814', '2020-02-06 19:31:13');
INSERT INTO `bitacora_movimientos` VALUES (10254, 3257, 'Nota Remision', 'Agregamos una Nota de Remision:2814', '2020-02-06 19:31:13');
INSERT INTO `bitacora_movimientos` VALUES (10255, 3258, 'Nota Descripcion', 'Agregamos los detalles de la Nota de remsion:2815', '2020-02-06 19:31:13');
INSERT INTO `bitacora_movimientos` VALUES (10256, 3258, 'Nota Descripcion', 'Agregamos los detalles de la Nota de remsion:2815', '2020-02-06 19:31:13');
INSERT INTO `bitacora_movimientos` VALUES (10257, 3258, 'Nota Remision', 'Agregamos una Nota de Remision:2815', '2020-02-06 19:31:13');
INSERT INTO `bitacora_movimientos` VALUES (10258, 3258, 'guias', 'Nuevo guia creado con el ID :0', '2020-02-06 19:33:47');
INSERT INTO `bitacora_movimientos` VALUES (10259, 3260, 'banners', 'Nuevo banner creado id- 1', '2020-02-10 13:05:54');
INSERT INTO `bitacora_movimientos` VALUES (10260, 3260, 'banners', 'Modificacion de banner id- 1', '2020-02-10 13:06:50');
INSERT INTO `bitacora_movimientos` VALUES (10261, 3262, 'pedidos', 'Se ha agregado una foto de anticipo al pedido # 2819.', '2020-02-11 11:50:06');
INSERT INTO `bitacora_movimientos` VALUES (10262, 3263, 'pedidos', 'Se ha agregado una foto de anticipo al pedido # 2819.', '2020-02-11 11:51:40');
INSERT INTO `bitacora_movimientos` VALUES (10263, 3264, 'nota_remision_depositos', 'Nuevo deposito creado con el ID :1263', '2020-02-11 11:55:03');
INSERT INTO `bitacora_movimientos` VALUES (10264, 3264, 'nota_remision_depositos', 'Se elimino el Id :1262', '2020-02-11 11:56:27');
INSERT INTO `bitacora_movimientos` VALUES (10265, 3264, 'guias', 'Nuevo guia creado con el ID :0', '2020-02-11 11:59:18');
INSERT INTO `bitacora_movimientos` VALUES (10266, 3265, 'Categorias', 'Modificamos Categorias precio con el ID :8', '2020-02-11 12:42:03');
INSERT INTO `bitacora_movimientos` VALUES (10267, 3265, 'Categorias', 'Modificamos Categorias precio con el ID :7', '2020-02-11 12:42:23');
INSERT INTO `bitacora_movimientos` VALUES (10268, 3265, 'Categorias', 'Modificamos Categorias precio con el ID :9', '2020-02-11 12:42:44');
INSERT INTO `bitacora_movimientos` VALUES (10269, 3265, 'niveles', 'Modificamos Nivel con el ID :7', '2020-02-11 12:43:39');
INSERT INTO `bitacora_movimientos` VALUES (10270, 3265, 'niveles', 'Modificamos Nivel con el ID :8', '2020-02-11 12:44:11');
INSERT INTO `bitacora_movimientos` VALUES (10271, 3265, 'niveles', 'Modificamos Nivel con el ID :9', '2020-02-11 12:44:21');
INSERT INTO `bitacora_movimientos` VALUES (10272, 3265, 'Catalogos', 'Elimino Categoria de precio por nivel creada con el IDCAT :8 Y idniveles: 9', '2020-02-11 12:44:54');
INSERT INTO `bitacora_movimientos` VALUES (10273, 3265, 'Catalogos', 'Elimino Categoria de precio por nivel creada con el IDCAT :8 Y idniveles: 8', '2020-02-11 12:45:00');
INSERT INTO `bitacora_movimientos` VALUES (10274, 3265, 'Catalogos', 'Elimino Categoria de precio por nivel creada con el IDCAT :8 Y idniveles: 7', '2020-02-11 12:45:05');
INSERT INTO `bitacora_movimientos` VALUES (10275, 3265, 'Catalogos', 'Elimino Categoria de precio por nivel creada con el IDCAT :7 Y idniveles: 9', '2020-02-11 12:45:10');
INSERT INTO `bitacora_movimientos` VALUES (10276, 3265, 'Catalogos', 'Elimino Categoria de precio por nivel creada con el IDCAT :7 Y idniveles: 8', '2020-02-11 12:45:16');
INSERT INTO `bitacora_movimientos` VALUES (10277, 3265, 'Catalogos', 'Elimino Categoria de precio por nivel creada con el IDCAT :7 Y idniveles: 7', '2020-02-11 12:45:21');
INSERT INTO `bitacora_movimientos` VALUES (10278, 3265, 'Catalogos', 'Elimino Categoria de precio por nivel creada con el IDCAT :9 Y idniveles: 7', '2020-02-11 12:45:27');
INSERT INTO `bitacora_movimientos` VALUES (10279, 3265, 'Catalogos', 'Nueva Categoria de precio por nivel creada con el ID :0', '2020-02-11 12:48:24');
INSERT INTO `bitacora_movimientos` VALUES (10280, 3265, 'Categorias', 'Modificamos Categorias precio con el ID :9', '2020-02-11 12:51:41');
INSERT INTO `bitacora_movimientos` VALUES (10281, 3265, 'Productos', 'Nuevo producto con el ID :SL1001', '2020-02-11 12:56:16');
INSERT INTO `bitacora_movimientos` VALUES (10282, 3266, 'Productos', 'Modificamos el producto con el ID :SL1001', '2020-02-11 13:00:03');
INSERT INTO `bitacora_movimientos` VALUES (10283, 3265, 'Tallas', 'Nueva Talla con el ID :36', '2020-02-11 13:01:05');
INSERT INTO `bitacora_movimientos` VALUES (10284, 3266, 'Productos', 'Modificamos el producto con el ID :SL1001', '2020-02-11 13:05:11');
INSERT INTO `bitacora_movimientos` VALUES (10285, 3265, 'entradas', 'Nueva entrada con el ID :501', '2020-02-11 13:09:14');
INSERT INTO `bitacora_movimientos` VALUES (10286, 3265, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :501 IDproducto: SL1001', '2020-02-11 13:09:14');
INSERT INTO `bitacora_movimientos` VALUES (10287, 3268, 'Productos', 'Nuevo producto con el ID :asdasd', '2020-02-11 15:19:00');
INSERT INTO `bitacora_movimientos` VALUES (10288, 3273, 'Clientes', 'Modificar Cliente con el ID :4113', '2020-02-13 14:12:58');
INSERT INTO `bitacora_movimientos` VALUES (10289, 3273, 'Clientes', 'Modificar Cliente con el ID :4119', '2020-02-13 14:13:37');
INSERT INTO `bitacora_movimientos` VALUES (10290, 3274, 'subcategoria', 'Se elimino el Id :13', '2020-02-13 15:51:28');
INSERT INTO `bitacora_movimientos` VALUES (10291, 3275, 'Productos', 'Modificamos el producto con el ID :c203', '2020-02-17 13:39:53');
INSERT INTO `bitacora_movimientos` VALUES (10292, 3275, 'Productos', 'Modificamos el producto con el ID :c202', '2020-02-17 13:40:14');
INSERT INTO `bitacora_movimientos` VALUES (10293, 3276, 'guias', 'Nuevo guia creado con el ID :', '2020-02-17 14:10:58');
INSERT INTO `bitacora_movimientos` VALUES (10294, 3276, 'Tallas', 'Nueva Talla con el ID :37', '2020-02-17 14:11:26');
INSERT INTO `bitacora_movimientos` VALUES (10295, 3276, 'Productos', 'Nuevo producto con el ID :BA01', '2020-02-17 14:16:02');
INSERT INTO `bitacora_movimientos` VALUES (10296, 3276, 'productos_imagenes', 'Guardando foto del producto con ID:-BA01 y el registro con ID:-23', '2020-02-17 14:16:44');
INSERT INTO `bitacora_movimientos` VALUES (10297, 3276, 'productos_imagenes', 'Guardando foto del producto con ID:-BA01 y el registro con ID:-24', '2020-02-17 14:17:00');
INSERT INTO `bitacora_movimientos` VALUES (10298, 3276, 'entradas', 'Nueva entrada con el ID :502', '2020-02-17 14:18:36');
INSERT INTO `bitacora_movimientos` VALUES (10299, 3276, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :502 IDproducto: BA01', '2020-02-17 14:18:36');
INSERT INTO `bitacora_movimientos` VALUES (10300, 3276, 'Productos', 'Modificamos el producto con el ID :BA01', '2020-02-17 14:22:55');
INSERT INTO `bitacora_movimientos` VALUES (10301, 3276, 'productos_imagenes', 'Modificamos datos de foto del producto-BA01 y el registro con ID:-23', '2020-02-17 14:23:23');
INSERT INTO `bitacora_movimientos` VALUES (10302, 3279, 'Clientes', 'Modificar Cliente con el ID :4113', '2020-02-17 15:56:36');
INSERT INTO `bitacora_movimientos` VALUES (10303, 3280, 'Nota Descripcion', 'Agregamos los detalles de la Nota de remsion:2820', '2020-02-17 16:29:36');
INSERT INTO `bitacora_movimientos` VALUES (10304, 3280, 'Nota Descripcion', 'Agregamos los detalles de la Nota de remsion:2820', '2020-02-17 16:29:36');
INSERT INTO `bitacora_movimientos` VALUES (10305, 3280, 'Nota Remision', 'Agregamos una Nota de Remision:2820', '2020-02-17 16:29:36');
INSERT INTO `bitacora_movimientos` VALUES (10306, 3279, 'guias', 'Modificacion de guia creado con el ID :1234567890', '2020-02-17 16:30:22');
INSERT INTO `bitacora_movimientos` VALUES (10307, 3280, 'guias', 'Nuevo guia creado con el ID :0', '2020-02-17 16:42:58');
INSERT INTO `bitacora_movimientos` VALUES (10308, 3280, 'guias', 'Nuevo guia creado con el ID :0', '2020-02-17 16:44:19');
INSERT INTO `bitacora_movimientos` VALUES (10309, 3279, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :7 IDproducto: 1', '2020-02-17 17:05:09');
INSERT INTO `bitacora_movimientos` VALUES (10310, 3279, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :7 IDproducto: 2', '2020-02-17 17:05:09');
INSERT INTO `bitacora_movimientos` VALUES (10311, 3280, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :7 IDproducto: 1', '2020-02-17 17:05:18');
INSERT INTO `bitacora_movimientos` VALUES (10312, 3280, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :7 IDproducto: 2', '2020-02-17 17:05:18');
INSERT INTO `bitacora_movimientos` VALUES (10313, 3280, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :7 IDproducto: 1', '2020-02-17 17:07:29');
INSERT INTO `bitacora_movimientos` VALUES (10314, 3280, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :7 IDproducto: 2', '2020-02-17 17:07:29');
INSERT INTO `bitacora_movimientos` VALUES (10315, 3280, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :7 IDproducto: 3', '2020-02-17 17:07:29');
INSERT INTO `bitacora_movimientos` VALUES (10316, 3280, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :7 IDproducto: 4', '2020-02-17 17:07:29');
INSERT INTO `bitacora_movimientos` VALUES (10317, 3280, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :7 IDproducto: 5', '2020-02-17 17:07:29');
INSERT INTO `bitacora_movimientos` VALUES (10318, 3280, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :7 IDproducto: 6', '2020-02-17 17:07:29');
INSERT INTO `bitacora_movimientos` VALUES (10319, 3290, 'etiquetas', 'Se elimino el Id :7', '2020-02-18 15:00:55');
INSERT INTO `bitacora_movimientos` VALUES (10320, 3290, 'etiqueta', 'Nueva Lista de etiqetas con el id :8', '2020-02-18 15:01:14');
INSERT INTO `bitacora_movimientos` VALUES (10321, 3290, 'etiquetas', 'Se elimino el Id :8', '2020-02-18 15:01:18');
INSERT INTO `bitacora_movimientos` VALUES (10322, 3292, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :6 IDproducto: 1', '2020-02-18 15:43:55');
INSERT INTO `bitacora_movimientos` VALUES (10323, 3292, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :6 IDproducto: 2', '2020-02-18 15:43:55');
INSERT INTO `bitacora_movimientos` VALUES (10324, 3303, 'banners', 'Modificacion de banner id- 1', '2020-02-20 21:36:47');
INSERT INTO `bitacora_movimientos` VALUES (10325, 3303, 'banners', 'Modificacion de banner id- 1', '2020-02-20 21:37:23');
INSERT INTO `bitacora_movimientos` VALUES (10326, 3305, 'Productos', 'Nuevo producto con el ID :L2ST001', '2020-02-24 14:32:39');
INSERT INTO `bitacora_movimientos` VALUES (10327, 3305, 'entradas', 'Nueva entrada con el ID :503', '2020-02-24 14:33:37');
INSERT INTO `bitacora_movimientos` VALUES (10328, 3305, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :503 IDproducto: L2ST001', '2020-02-24 14:33:37');
INSERT INTO `bitacora_movimientos` VALUES (10329, 3306, 'guias', 'Nuevo guia creado con el ID :', '2020-02-24 17:52:18');
INSERT INTO `bitacora_movimientos` VALUES (10330, 3306, 'guias', 'Nuevo guia creado con el ID :', '2020-02-24 17:52:31');
INSERT INTO `bitacora_movimientos` VALUES (10331, 3306, 'guias', 'Nuevo guia creado con el ID :', '2020-02-24 17:52:46');
INSERT INTO `bitacora_movimientos` VALUES (10332, 3306, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :6 IDproducto: 1', '2020-02-24 17:57:44');
INSERT INTO `bitacora_movimientos` VALUES (10333, 3306, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :6 IDproducto: 2', '2020-02-24 17:57:44');
INSERT INTO `bitacora_movimientos` VALUES (10334, 3306, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :6 IDproducto: 3', '2020-02-24 17:57:44');
INSERT INTO `bitacora_movimientos` VALUES (10335, 3306, 'Categorias', 'Modificamos la Categoría con el ID :12', '2020-02-24 18:04:08');
INSERT INTO `bitacora_movimientos` VALUES (10336, 3306, 'Productos', 'Nuevo producto con el ID :L2S001', '2020-02-24 18:06:29');
INSERT INTO `bitacora_movimientos` VALUES (10337, 3306, 'Tallas', 'Modificamos la talla con el ID :29', '2020-02-24 18:08:16');
INSERT INTO `bitacora_movimientos` VALUES (10338, 3306, 'Tallas', 'Modificamos la talla con el ID :29', '2020-02-24 18:08:30');
INSERT INTO `bitacora_movimientos` VALUES (10339, 3306, 'tallas', 'Se elimino el Id :29', '2020-02-24 18:08:52');
INSERT INTO `bitacora_movimientos` VALUES (10340, 3306, 'tallas', 'Se elimino el Id :30', '2020-02-24 18:08:57');
INSERT INTO `bitacora_movimientos` VALUES (10341, 3306, 'tallas', 'Se elimino el Id :28', '2020-02-24 18:09:00');
INSERT INTO `bitacora_movimientos` VALUES (10342, 3306, 'tallas', 'Se elimino el Id :31', '2020-02-24 18:09:04');
INSERT INTO `bitacora_movimientos` VALUES (10343, 3306, 'tallas', 'Se elimino el Id :32', '2020-02-24 18:09:07');
INSERT INTO `bitacora_movimientos` VALUES (10344, 3306, 'tallas', 'Se elimino el Id :33', '2020-02-24 18:09:10');
INSERT INTO `bitacora_movimientos` VALUES (10345, 3306, 'tallas', 'Se elimino el Id :34', '2020-02-24 18:09:13');
INSERT INTO `bitacora_movimientos` VALUES (10346, 3306, 'tallas', 'Se elimino el Id :35', '2020-02-24 18:09:17');
INSERT INTO `bitacora_movimientos` VALUES (10347, 3306, 'tallas', 'Se elimino el Id :36', '2020-02-24 18:09:20');
INSERT INTO `bitacora_movimientos` VALUES (10348, 3306, 'tallas', 'Se elimino el Id :37', '2020-02-24 18:09:23');
INSERT INTO `bitacora_movimientos` VALUES (10349, 3306, 'Tallas', 'Nueva Talla con el ID :38', '2020-02-24 18:09:41');
INSERT INTO `bitacora_movimientos` VALUES (10350, 3306, 'Tallas', 'Modificamos la talla con el ID :38', '2020-02-24 18:09:51');
INSERT INTO `bitacora_movimientos` VALUES (10351, 3306, 'Tallas', 'Nueva Talla con el ID :39', '2020-02-24 18:10:02');
INSERT INTO `bitacora_movimientos` VALUES (10352, 3306, 'Tallas', 'Nueva Talla con el ID :40', '2020-02-24 18:10:12');
INSERT INTO `bitacora_movimientos` VALUES (10353, 3306, 'Tallas', 'Nueva Talla con el ID :41', '2020-02-24 18:10:21');
INSERT INTO `bitacora_movimientos` VALUES (10354, 3306, 'Tallas', 'Nueva Talla con el ID :42', '2020-02-24 18:10:29');
INSERT INTO `bitacora_movimientos` VALUES (10355, 3306, 'Tallas', 'Nueva Talla con el ID :43', '2020-02-24 18:10:43');
INSERT INTO `bitacora_movimientos` VALUES (10356, 3306, 'Tallas', 'Nueva Talla con el ID :44', '2020-02-24 18:10:53');
INSERT INTO `bitacora_movimientos` VALUES (10357, 3306, 'Tallas', 'Modificamos la talla con el ID :42', '2020-02-24 18:11:01');
INSERT INTO `bitacora_movimientos` VALUES (10358, 3306, 'Tallas', 'Modificamos la talla con el ID :41', '2020-02-24 18:11:10');
INSERT INTO `bitacora_movimientos` VALUES (10359, 3306, 'Tallas', 'Modificamos la talla con el ID :40', '2020-02-24 18:11:18');
INSERT INTO `bitacora_movimientos` VALUES (10360, 3306, 'Tallas', 'Modificamos la talla con el ID :39', '2020-02-24 18:11:27');
INSERT INTO `bitacora_movimientos` VALUES (10361, 3306, 'Tallas', 'Nueva Talla con el ID :45', '2020-02-24 18:11:43');
INSERT INTO `bitacora_movimientos` VALUES (10362, 3306, 'Tallas', 'Nueva Talla con el ID :46', '2020-02-24 18:11:55');
INSERT INTO `bitacora_movimientos` VALUES (10363, 3306, 'Tallas', 'Nueva Talla con el ID :47', '2020-02-24 18:12:12');
INSERT INTO `bitacora_movimientos` VALUES (10364, 3306, 'Tallas', 'Nueva Talla con el ID :48', '2020-02-24 18:14:06');
INSERT INTO `bitacora_movimientos` VALUES (10365, 3306, 'Tallas', 'Nueva Talla con el ID :49', '2020-02-24 18:14:47');
INSERT INTO `bitacora_movimientos` VALUES (10366, 3306, 'Tallas', 'Nueva Talla con el ID :50', '2020-02-24 18:15:13');
INSERT INTO `bitacora_movimientos` VALUES (10367, 3306, 'Tallas', 'Nueva Talla con el ID :51', '2020-02-24 18:15:28');
INSERT INTO `bitacora_movimientos` VALUES (10368, 3306, 'Tallas', 'Nueva Talla con el ID :52', '2020-02-24 18:16:00');
INSERT INTO `bitacora_movimientos` VALUES (10369, 3306, 'Tallas', 'Nueva Talla con el ID :53', '2020-02-24 18:16:18');
INSERT INTO `bitacora_movimientos` VALUES (10370, 3306, 'Tallas', 'Modificamos la talla con el ID :38', '2020-02-24 18:16:32');
INSERT INTO `bitacora_movimientos` VALUES (10371, 3306, 'entradas', 'Nueva entrada con el ID :504', '2020-02-24 18:18:28');
INSERT INTO `bitacora_movimientos` VALUES (10372, 3306, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :504 IDproducto: L2S001', '2020-02-24 18:18:28');
INSERT INTO `bitacora_movimientos` VALUES (10373, 3306, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :504 IDproducto: L2S001', '2020-02-24 18:18:28');
INSERT INTO `bitacora_movimientos` VALUES (10374, 3306, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :504 IDproducto: L2S001', '2020-02-24 18:18:28');
INSERT INTO `bitacora_movimientos` VALUES (10375, 3306, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :504 IDproducto: L2S001', '2020-02-24 18:18:28');
INSERT INTO `bitacora_movimientos` VALUES (10376, 3306, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :504 IDproducto: L2S001', '2020-02-24 18:18:28');
INSERT INTO `bitacora_movimientos` VALUES (10377, 3306, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :504 IDproducto: L2S001', '2020-02-24 18:18:28');
INSERT INTO `bitacora_movimientos` VALUES (10378, 3306, 'Productos', 'Nuevo producto con el ID :L2S002', '2020-02-24 18:21:15');
INSERT INTO `bitacora_movimientos` VALUES (10379, 3306, 'entradas', 'Nueva entrada con el ID :505', '2020-02-24 18:24:12');
INSERT INTO `bitacora_movimientos` VALUES (10380, 3306, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :505 IDproducto: L2S002', '2020-02-24 18:24:12');
INSERT INTO `bitacora_movimientos` VALUES (10381, 3306, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :505 IDproducto: L2S002', '2020-02-24 18:24:12');
INSERT INTO `bitacora_movimientos` VALUES (10382, 3306, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :505 IDproducto: L2S002', '2020-02-24 18:24:12');
INSERT INTO `bitacora_movimientos` VALUES (10383, 3306, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :505 IDproducto: L2S002', '2020-02-24 18:24:12');
INSERT INTO `bitacora_movimientos` VALUES (10384, 3306, 'productos_imagenes', 'Guardando foto del producto con ID:-L2S002 y el registro con ID:-25', '2020-02-24 18:25:12');
INSERT INTO `bitacora_movimientos` VALUES (10385, 3306, 'productos_imagenes', 'Guardando foto del producto con ID:-L2S002 y el registro con ID:-26', '2020-02-24 18:25:27');
INSERT INTO `bitacora_movimientos` VALUES (10386, 3306, 'Categorias', 'Modificamos la Categoría con el ID :13', '2020-02-24 18:26:35');
INSERT INTO `bitacora_movimientos` VALUES (10387, 3306, 'Categorias', 'Modificamos la Categoría con el ID :14', '2020-02-24 18:26:45');
INSERT INTO `bitacora_movimientos` VALUES (10388, 3306, 'Categorias', 'Modificamos la Categoría con el ID :15', '2020-02-24 18:26:57');
INSERT INTO `bitacora_movimientos` VALUES (10389, 3306, 'guias', 'Nuevo guia creado con el ID :', '2020-02-24 18:27:33');
INSERT INTO `bitacora_movimientos` VALUES (10390, 3306, 'guias', 'Nuevo guia creado con el ID :', '2020-02-24 18:27:46');
INSERT INTO `bitacora_movimientos` VALUES (10391, 3306, 'guias', 'Nuevo guia creado con el ID :', '2020-02-24 18:27:54');
INSERT INTO `bitacora_movimientos` VALUES (10392, 3306, 'guias', 'Modificacion de guia creado con el ID :', '2020-02-24 18:28:17');
INSERT INTO `bitacora_movimientos` VALUES (10393, 3306, 'guias', 'Modificacion de guia creado con el ID :', '2020-02-24 18:28:27');
INSERT INTO `bitacora_movimientos` VALUES (10394, 3306, 'guias', 'Nuevo guia creado con el ID :', '2020-02-24 18:28:41');
INSERT INTO `bitacora_movimientos` VALUES (10395, 3306, 'guias', 'Nuevo guia creado con el ID :', '2020-02-24 18:28:50');
INSERT INTO `bitacora_movimientos` VALUES (10396, 3306, 'guias', 'Modificacion de guia creado con el ID :', '2020-02-24 18:29:13');
INSERT INTO `bitacora_movimientos` VALUES (10397, 3306, 'guias', 'Nuevo guia creado con el ID :', '2020-02-24 18:29:25');
INSERT INTO `bitacora_movimientos` VALUES (10398, 3306, 'guias', 'Nuevo guia creado con el ID :', '2020-02-24 18:29:33');
INSERT INTO `bitacora_movimientos` VALUES (10399, 3306, 'guias', 'Modificacion de guia creado con el ID :', '2020-02-24 18:30:15');
INSERT INTO `bitacora_movimientos` VALUES (10400, 3306, 'guias', 'Modificacion de guia creado con el ID :', '2020-02-24 18:30:32');
INSERT INTO `bitacora_movimientos` VALUES (10401, 3306, 'productos', 'Se elimino el Id :A', '2020-02-24 18:31:48');
INSERT INTO `bitacora_movimientos` VALUES (10402, 3306, 'productos', 'Se elimino el Id :BA01', '2020-02-24 18:31:56');
INSERT INTO `bitacora_movimientos` VALUES (10403, 3306, 'productos', 'Se elimino el Id :c201', '2020-02-24 18:32:04');
INSERT INTO `bitacora_movimientos` VALUES (10404, 3306, 'productos', 'Se elimino el Id :c202', '2020-02-24 18:32:10');
INSERT INTO `bitacora_movimientos` VALUES (10405, 3306, 'productos', 'Se elimino el Id :c203', '2020-02-24 18:33:38');
INSERT INTO `bitacora_movimientos` VALUES (10406, 3306, 'productos', 'Se elimino el Id :L2ST001', '2020-02-24 18:34:44');
INSERT INTO `bitacora_movimientos` VALUES (10407, 3306, 'productos', 'Se elimino el Id :RP01', '2020-02-24 18:34:51');
INSERT INTO `bitacora_movimientos` VALUES (10408, 3306, 'productos', 'Se elimino el Id :RP02', '2020-02-24 18:34:59');
INSERT INTO `bitacora_movimientos` VALUES (10409, 3306, 'productos', 'Se elimino el Id :RP03', '2020-02-24 18:35:05');
INSERT INTO `bitacora_movimientos` VALUES (10410, 3306, 'productos', 'Se elimino el Id :SL1001', '2020-02-24 18:35:12');
INSERT INTO `bitacora_movimientos` VALUES (10411, 3306, 'productos', 'Se elimino el Id :V001', '2020-02-24 18:35:21');
INSERT INTO `bitacora_movimientos` VALUES (10412, 3306, 'productos', 'Se elimino el Id :V002', '2020-02-24 18:35:27');
INSERT INTO `bitacora_movimientos` VALUES (10413, 3306, 'productos', 'Se elimino el Id :V003', '2020-02-24 18:35:32');
INSERT INTO `bitacora_movimientos` VALUES (10414, 3306, 'Productos', 'Modificamos el producto con el ID :L2S002', '2020-02-24 18:36:09');
INSERT INTO `bitacora_movimientos` VALUES (10415, 3306, 'Productos', 'Nuevo producto con el ID :L2JS001', '2020-02-24 18:45:00');
INSERT INTO `bitacora_movimientos` VALUES (10416, 3306, 'entradas', 'Nueva entrada con el ID :506', '2020-02-24 18:45:27');
INSERT INTO `bitacora_movimientos` VALUES (10417, 3306, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :506 IDproducto: L2JS001', '2020-02-24 18:45:27');
INSERT INTO `bitacora_movimientos` VALUES (10418, 3306, 'guias', 'Nuevo guia creado con el ID :0', '2020-02-24 19:03:42');
INSERT INTO `bitacora_movimientos` VALUES (10419, 3306, 'banners', 'Modificacion de banner id- 1', '2020-02-24 19:20:01');
INSERT INTO `bitacora_movimientos` VALUES (10420, 3306, 'Clientes', 'Nuevo Cliente creado con el ID :4125', '2020-02-24 19:24:36');
INSERT INTO `bitacora_movimientos` VALUES (10421, 3306, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :6 IDproducto: 1', '2020-02-24 19:27:33');
INSERT INTO `bitacora_movimientos` VALUES (10422, 3306, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :6 IDproducto: 2', '2020-02-24 19:27:33');
INSERT INTO `bitacora_movimientos` VALUES (10423, 3307, 'Productos', 'Modificamos el producto con el ID :L2JS001', '2020-02-24 22:01:22');
INSERT INTO `bitacora_movimientos` VALUES (10424, 3311, 'entradas', 'Nueva entrada con el ID :507', '2020-02-26 12:09:33');
INSERT INTO `bitacora_movimientos` VALUES (10425, 3311, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :507 IDproducto: L2JS001', '2020-02-26 12:09:33');
INSERT INTO `bitacora_movimientos` VALUES (10426, 3317, 'perfiles', 'Modificacion del perfil creado -1', '2020-02-27 14:20:53');
INSERT INTO `bitacora_movimientos` VALUES (10427, 3316, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-02-27 14:27:58');
INSERT INTO `bitacora_movimientos` VALUES (10428, 3318, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-02-27 15:27:57');
INSERT INTO `bitacora_movimientos` VALUES (10429, 3318, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-02-27 15:29:23');
INSERT INTO `bitacora_movimientos` VALUES (10430, 3318, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-02-27 15:29:42');
INSERT INTO `bitacora_movimientos` VALUES (10431, 3318, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-02-27 15:30:37');
INSERT INTO `bitacora_movimientos` VALUES (10432, 3318, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-02-27 15:32:29');
INSERT INTO `bitacora_movimientos` VALUES (10433, 3319, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-02-27 22:30:19');
INSERT INTO `bitacora_movimientos` VALUES (10434, 3319, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-02-27 22:30:56');
INSERT INTO `bitacora_movimientos` VALUES (10435, 3319, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-02-27 22:31:28');
INSERT INTO `bitacora_movimientos` VALUES (10436, 3319, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-02-27 22:31:54');
INSERT INTO `bitacora_movimientos` VALUES (10437, 3319, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-02-27 22:32:12');
INSERT INTO `bitacora_movimientos` VALUES (10438, 3320, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-02-27 23:11:21');
INSERT INTO `bitacora_movimientos` VALUES (10439, 3322, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-02-28 10:13:54');
INSERT INTO `bitacora_movimientos` VALUES (10440, 3322, 'preguntas', 'Modificacion de pregunta con el ID :2', '2020-02-28 10:17:00');
INSERT INTO `bitacora_movimientos` VALUES (10441, 3322, 'preguntas', 'Modificacion de pregunta con el ID :2', '2020-02-28 10:17:07');
INSERT INTO `bitacora_movimientos` VALUES (10442, 3326, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-02 13:31:12');
INSERT INTO `bitacora_movimientos` VALUES (10443, 3326, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-02 13:31:19');
INSERT INTO `bitacora_movimientos` VALUES (10444, 3326, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-02 14:59:55');
INSERT INTO `bitacora_movimientos` VALUES (10445, 3326, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-02 15:00:23');
INSERT INTO `bitacora_movimientos` VALUES (10446, 3326, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-02 15:00:43');
INSERT INTO `bitacora_movimientos` VALUES (10447, 3326, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-02 15:00:55');
INSERT INTO `bitacora_movimientos` VALUES (10448, 3326, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-02 15:02:18');
INSERT INTO `bitacora_movimientos` VALUES (10449, 3326, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-02 15:49:03');
INSERT INTO `bitacora_movimientos` VALUES (10450, 3327, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-03 10:52:02');
INSERT INTO `bitacora_movimientos` VALUES (10451, 3327, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-03 10:54:27');
INSERT INTO `bitacora_movimientos` VALUES (10452, 3328, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-03 12:02:10');
INSERT INTO `bitacora_movimientos` VALUES (10453, 3328, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-03 12:02:48');
INSERT INTO `bitacora_movimientos` VALUES (10454, 3338, 'banners', 'Modificacion de banner id- 1', '2020-03-09 15:39:21');
INSERT INTO `bitacora_movimientos` VALUES (10455, 3338, 'banners', 'Modificacion de banner id- 2', '2020-03-09 15:40:12');
INSERT INTO `bitacora_movimientos` VALUES (10456, 3339, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-09 17:49:17');
INSERT INTO `bitacora_movimientos` VALUES (10457, 3339, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-09 17:49:53');
INSERT INTO `bitacora_movimientos` VALUES (10458, 3341, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-10 10:01:36');
INSERT INTO `bitacora_movimientos` VALUES (10459, 3341, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-10 10:01:52');
INSERT INTO `bitacora_movimientos` VALUES (10460, 3341, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-10 10:02:00');
INSERT INTO `bitacora_movimientos` VALUES (10461, 3341, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-10 10:02:12');
INSERT INTO `bitacora_movimientos` VALUES (10462, 3356, 'Productos', 'Nuevo producto con el ID :anillo', '2020-03-18 13:37:33');
INSERT INTO `bitacora_movimientos` VALUES (10463, 3356, 'entradas', 'Nueva entrada con el ID :508', '2020-03-18 13:39:09');
INSERT INTO `bitacora_movimientos` VALUES (10464, 3356, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :508 IDproducto: ANILLO', '2020-03-18 13:39:09');
INSERT INTO `bitacora_movimientos` VALUES (10465, 3361, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-19 10:41:47');
INSERT INTO `bitacora_movimientos` VALUES (10466, 3361, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-19 10:42:53');
INSERT INTO `bitacora_movimientos` VALUES (10467, 3361, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-19 10:43:40');
INSERT INTO `bitacora_movimientos` VALUES (10468, 3361, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-19 10:43:54');
INSERT INTO `bitacora_movimientos` VALUES (10469, 3363, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-19 10:45:17');
INSERT INTO `bitacora_movimientos` VALUES (10470, 3361, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-19 10:46:39');
INSERT INTO `bitacora_movimientos` VALUES (10471, 3364, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-19 10:52:42');
INSERT INTO `bitacora_movimientos` VALUES (10472, 3363, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-19 10:56:43');
INSERT INTO `bitacora_movimientos` VALUES (10473, 3364, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-19 10:57:01');
INSERT INTO `bitacora_movimientos` VALUES (10474, 3363, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-19 10:57:08');
INSERT INTO `bitacora_movimientos` VALUES (10475, 3363, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-19 10:57:15');
INSERT INTO `bitacora_movimientos` VALUES (10476, 3363, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-19 10:57:24');
INSERT INTO `bitacora_movimientos` VALUES (10477, 3363, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-19 10:57:58');
INSERT INTO `bitacora_movimientos` VALUES (10478, 3364, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-19 11:10:44');
INSERT INTO `bitacora_movimientos` VALUES (10479, 3364, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-19 11:11:59');
INSERT INTO `bitacora_movimientos` VALUES (10480, 3364, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-19 11:12:34');
INSERT INTO `bitacora_movimientos` VALUES (10481, 3364, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-19 11:13:42');
INSERT INTO `bitacora_movimientos` VALUES (10482, 3364, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-19 11:15:06');
INSERT INTO `bitacora_movimientos` VALUES (10483, 3364, 'Productos', 'Modificamos el producto con el ID :anillo', '2020-03-19 11:47:42');
INSERT INTO `bitacora_movimientos` VALUES (10484, 3364, 'Productos', 'Modificamos el producto con el ID :anillo', '2020-03-19 11:49:46');
INSERT INTO `bitacora_movimientos` VALUES (10485, 3364, 'Productos', 'Modificamos el producto con el ID :L2JS001', '2020-03-19 11:50:13');
INSERT INTO `bitacora_movimientos` VALUES (10486, 3364, 'Productos', 'Modificamos el producto con el ID :L2JS001', '2020-03-19 11:51:01');
INSERT INTO `bitacora_movimientos` VALUES (10487, 3364, 'Productos', 'Modificamos el producto con el ID :L2S001', '2020-03-19 11:51:18');
INSERT INTO `bitacora_movimientos` VALUES (10488, 3364, 'Productos', 'Modificamos el producto con el ID :L2S001', '2020-03-19 11:51:56');
INSERT INTO `bitacora_movimientos` VALUES (10489, 3364, 'Productos', 'Modificamos el producto con el ID :L2S002', '2020-03-19 11:53:32');
INSERT INTO `bitacora_movimientos` VALUES (10490, 3364, 'Productos', 'Nuevo producto con el ID :motx', '2020-03-19 11:56:07');
INSERT INTO `bitacora_movimientos` VALUES (10491, 3364, 'entradas', 'Nueva entrada con el ID :509', '2020-03-19 11:57:21');
INSERT INTO `bitacora_movimientos` VALUES (10492, 3364, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :509 IDproducto: MOTX', '2020-03-19 11:57:21');
INSERT INTO `bitacora_movimientos` VALUES (10493, 3364, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-19 12:23:03');
INSERT INTO `bitacora_movimientos` VALUES (10494, 3365, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-19 13:30:06');
INSERT INTO `bitacora_movimientos` VALUES (10495, 3365, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-19 13:31:53');
INSERT INTO `bitacora_movimientos` VALUES (10496, 3365, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-19 13:52:41');
INSERT INTO `bitacora_movimientos` VALUES (10497, 3365, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-19 13:53:30');
INSERT INTO `bitacora_movimientos` VALUES (10498, 3365, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-19 13:54:27');
INSERT INTO `bitacora_movimientos` VALUES (10499, 3370, 'entradas', 'Nueva entrada con el ID :510', '2020-03-20 13:46:49');
INSERT INTO `bitacora_movimientos` VALUES (10500, 3370, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :510 IDproducto: MOTOX', '2020-03-20 13:46:49');
INSERT INTO `bitacora_movimientos` VALUES (10501, 3370, 'Productos', 'Nuevo producto con el ID :CARAT1', '2020-03-20 13:58:03');
INSERT INTO `bitacora_movimientos` VALUES (10502, 3370, 'entradas', 'Nueva entrada con el ID :511', '2020-03-20 13:58:24');
INSERT INTO `bitacora_movimientos` VALUES (10503, 3370, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :511 IDproducto: CARAT1', '2020-03-20 13:58:24');
INSERT INTO `bitacora_movimientos` VALUES (10504, 3376, 'banners', 'Modificacion de banner id- 1', '2020-03-20 21:56:47');
INSERT INTO `bitacora_movimientos` VALUES (10505, 3376, 'banners', 'Modificacion de banner id- 2', '2020-03-20 22:00:11');
INSERT INTO `bitacora_movimientos` VALUES (10506, 3376, 'banners', 'Modificacion de banner id- 2', '2020-03-20 22:00:43');
INSERT INTO `bitacora_movimientos` VALUES (10507, 3376, 'banners', 'Modificacion de banner id- 2', '2020-03-20 22:01:24');
INSERT INTO `bitacora_movimientos` VALUES (10508, 3376, 'banners', 'Modificacion de banner id- 1', '2020-03-20 22:05:53');
INSERT INTO `bitacora_movimientos` VALUES (10509, 3376, 'banners', 'Modificacion de banner id- 2', '2020-03-20 22:06:14');
INSERT INTO `bitacora_movimientos` VALUES (10510, 3376, 'banners', 'Modificacion de banner id- 1', '2020-03-20 22:06:48');
INSERT INTO `bitacora_movimientos` VALUES (10511, 3377, 'banners', 'Modificacion de banner id- 2', '2020-03-20 23:54:46');
INSERT INTO `bitacora_movimientos` VALUES (10512, 3377, 'banners', 'Modificacion de banner id- 2', '2020-03-20 23:55:05');
INSERT INTO `bitacora_movimientos` VALUES (10513, 3378, 'perfiles', 'Nuevo Perfil creado -6', '2020-03-21 11:52:24');
INSERT INTO `bitacora_movimientos` VALUES (10514, 3378, 'perfiles', 'Modificacion del perfil creado -6', '2020-03-21 11:52:41');
INSERT INTO `bitacora_movimientos` VALUES (10515, 3378, 'usuarios', 'Nuevo Usuario creado -TAPACHULA', '2020-03-21 11:54:43');
INSERT INTO `bitacora_movimientos` VALUES (10516, 3380, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-21 12:00:05');
INSERT INTO `bitacora_movimientos` VALUES (10517, 3380, 'Categorias', 'Modificamos Categorias precio con el ID :7', '2020-03-21 12:02:14');
INSERT INTO `bitacora_movimientos` VALUES (10518, 3380, 'Catalogos', 'Nueva Categoria de precio por nivel creada con el ID :0', '2020-03-21 12:28:49');
INSERT INTO `bitacora_movimientos` VALUES (10519, 3380, 'Categorias', 'Modificamos Categorias precio con el ID :7', '2020-03-21 12:29:11');
INSERT INTO `bitacora_movimientos` VALUES (10520, 3380, 'Catalogos', 'Nueva Categoria de precio por nivel creada con el ID :0', '2020-03-21 12:29:25');
INSERT INTO `bitacora_movimientos` VALUES (10521, 3380, 'Catalogos', 'Elimino Categoria de precio por nivel creada con el IDCAT :7 Y idniveles: 9', '2020-03-21 12:29:38');
INSERT INTO `bitacora_movimientos` VALUES (10522, 3380, 'Catalogos', 'Elimino Categoria de precio por nivel creada con el IDCAT :8 Y idniveles: 9', '2020-03-21 12:31:14');
INSERT INTO `bitacora_movimientos` VALUES (10523, 3380, 'Catalogos', 'Elimino Categoria de precio por nivel creada con el IDCAT :7 Y idniveles: 7', '2020-03-21 12:31:20');
INSERT INTO `bitacora_movimientos` VALUES (10524, 3380, 'Categorias', 'Modificamos la Categoría con el ID :12', '2020-03-21 12:36:26');
INSERT INTO `bitacora_movimientos` VALUES (10525, 3380, 'Categorias', 'Modificamos la Categoría con el ID :15', '2020-03-21 12:37:07');
INSERT INTO `bitacora_movimientos` VALUES (10526, 3380, 'Categorias', 'Modificamos la Categoría con el ID :12', '2020-03-21 12:37:21');
INSERT INTO `bitacora_movimientos` VALUES (10527, 3380, 'Categorias', 'Modificamos la Categoría con el ID :14', '2020-03-21 12:37:37');
INSERT INTO `bitacora_movimientos` VALUES (10528, 3380, 'Categorias', 'Modificamos la Categoría con el ID :13', '2020-03-21 12:37:53');
INSERT INTO `bitacora_movimientos` VALUES (10529, 3380, 'guias', 'Modificacion de guia creado con el ID :', '2020-03-21 12:38:18');
INSERT INTO `bitacora_movimientos` VALUES (10530, 3380, 'guias', 'Modificacion de guia creado con el ID :', '2020-03-21 12:38:31');
INSERT INTO `bitacora_movimientos` VALUES (10531, 3380, 'guias', 'Modificacion de guia creado con el ID :', '2020-03-21 12:38:58');
INSERT INTO `bitacora_movimientos` VALUES (10532, 3380, 'Productos', 'Nuevo producto con el ID :70015560', '2020-03-21 12:50:41');
INSERT INTO `bitacora_movimientos` VALUES (10533, 3380, 'productos_imagenes', 'Guardando foto del producto con ID:-70015560 y el registro con ID:-27', '2020-03-21 12:51:51');
INSERT INTO `bitacora_movimientos` VALUES (10534, 3380, 'entradas', 'Nueva entrada con el ID :512', '2020-03-21 12:53:45');
INSERT INTO `bitacora_movimientos` VALUES (10535, 3380, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :512 IDproducto: 70015560', '2020-03-21 12:53:45');
INSERT INTO `bitacora_movimientos` VALUES (10536, 3380, 'etiqueta', 'Nueva Lista de etiqetas con el id :9', '2020-03-21 12:59:23');
INSERT INTO `bitacora_movimientos` VALUES (10537, 3380, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :9 IDproducto: 1', '2020-03-21 13:00:05');
INSERT INTO `bitacora_movimientos` VALUES (10538, 3380, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :9 IDproducto: 2', '2020-03-21 13:00:05');
INSERT INTO `bitacora_movimientos` VALUES (10539, 3380, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :9 IDproducto: 3', '2020-03-21 13:00:05');
INSERT INTO `bitacora_movimientos` VALUES (10540, 3380, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :9 IDproducto: 4', '2020-03-21 13:00:05');
INSERT INTO `bitacora_movimientos` VALUES (10541, 3380, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :9 IDproducto: 5', '2020-03-21 13:00:05');
INSERT INTO `bitacora_movimientos` VALUES (10542, 3380, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :9 IDproducto: 6', '2020-03-21 13:00:05');
INSERT INTO `bitacora_movimientos` VALUES (10543, 3380, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :9 IDproducto: 7', '2020-03-21 13:00:05');
INSERT INTO `bitacora_movimientos` VALUES (10544, 3380, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :9 IDproducto: 8', '2020-03-21 13:00:05');
INSERT INTO `bitacora_movimientos` VALUES (10545, 3380, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :9 IDproducto: 9', '2020-03-21 13:00:05');
INSERT INTO `bitacora_movimientos` VALUES (10546, 3380, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :9 IDproducto: 10', '2020-03-21 13:00:05');
INSERT INTO `bitacora_movimientos` VALUES (10547, 3380, 'etiquetas', 'Se elimino el Id :6', '2020-03-21 13:01:26');
INSERT INTO `bitacora_movimientos` VALUES (10548, 3380, 'Nota Descripcion', 'Agregamos los detalles de la Nota de remsion:2849', '2020-03-21 13:11:49');
INSERT INTO `bitacora_movimientos` VALUES (10549, 3380, 'Nota Descripcion', 'Agregamos los detalles de la Nota de remsion:2849', '2020-03-21 13:11:49');
INSERT INTO `bitacora_movimientos` VALUES (10550, 3380, 'Nota Remision', 'Agregamos una Nota de Remision:2849', '2020-03-21 13:11:49');
INSERT INTO `bitacora_movimientos` VALUES (10551, 3380, 'banners', 'Modificacion de banner id- 1', '2020-03-21 13:18:57');
INSERT INTO `bitacora_movimientos` VALUES (10552, 3380, 'banners', 'Modificacion de banner id- 1', '2020-03-21 13:19:17');
INSERT INTO `bitacora_movimientos` VALUES (10553, 3382, 'Productos', 'Nuevo producto con el ID :121275', '2020-03-21 16:15:44');
INSERT INTO `bitacora_movimientos` VALUES (10554, 3383, 'Productos', 'Nuevo producto con el ID :70015720', '2020-03-21 16:32:06');
INSERT INTO `bitacora_movimientos` VALUES (10555, 3383, 'Productos', 'Nuevo producto con el ID :01', '2020-03-21 16:34:05');
INSERT INTO `bitacora_movimientos` VALUES (10556, 3384, 'Productos', 'Modificamos el producto con el ID :01', '2020-03-21 17:14:13');
INSERT INTO `bitacora_movimientos` VALUES (10557, 3384, 'productos', 'Se elimino el Id :121275', '2020-03-21 17:14:36');
INSERT INTO `bitacora_movimientos` VALUES (10558, 3384, 'Productos', 'Modificamos el producto con el ID :01', '2020-03-21 17:15:20');
INSERT INTO `bitacora_movimientos` VALUES (10559, 3384, 'productos_imagenes', 'Guardando foto del producto con ID:-01 y el registro con ID:-28', '2020-03-21 17:15:43');
INSERT INTO `bitacora_movimientos` VALUES (10560, 3384, 'productos_imagenes', 'Guardando foto del producto con ID:-01 y el registro con ID:-29', '2020-03-21 17:16:02');
INSERT INTO `bitacora_movimientos` VALUES (10561, 3384, 'productos_imagenes', 'Guardando foto del producto con ID:-01 y el registro con ID:-30', '2020-03-21 17:16:15');
INSERT INTO `bitacora_movimientos` VALUES (10562, 3384, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-21 17:19:26');
INSERT INTO `bitacora_movimientos` VALUES (10563, 3384, 'entradas', 'Nueva entrada con el ID :513', '2020-03-21 17:19:48');
INSERT INTO `bitacora_movimientos` VALUES (10564, 3384, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :513 IDproducto: 01', '2020-03-21 17:19:48');
INSERT INTO `bitacora_movimientos` VALUES (10565, 3385, 'Nota Descripcion', 'Agregamos los detalles de la Nota de remsion:2851', '2020-03-23 17:31:23');
INSERT INTO `bitacora_movimientos` VALUES (10566, 3385, 'Nota Descripcion', 'Agregamos los detalles de la Nota de remsion:2851', '2020-03-23 17:31:23');
INSERT INTO `bitacora_movimientos` VALUES (10567, 3385, 'Nota Remision', 'Agregamos una Nota de Remision:2851', '2020-03-23 17:31:23');
INSERT INTO `bitacora_movimientos` VALUES (10568, 3388, 'productos', 'Se elimino el Id :70015560', '2020-03-26 18:56:36');
INSERT INTO `bitacora_movimientos` VALUES (10569, 3388, 'productos', 'Se elimino el Id :70015720', '2020-03-26 18:56:45');
INSERT INTO `bitacora_movimientos` VALUES (10570, 3388, 'productos', 'Se elimino el Id :ANILLO', '2020-03-26 18:56:53');
INSERT INTO `bitacora_movimientos` VALUES (10571, 3388, 'productos', 'Se elimino el Id :CARAT1', '2020-03-26 18:56:59');
INSERT INTO `bitacora_movimientos` VALUES (10572, 3388, 'productos', 'Se elimino el Id :L2JS001', '2020-03-26 18:57:22');
INSERT INTO `bitacora_movimientos` VALUES (10573, 3388, 'productos', 'Se elimino el Id :L2S001', '2020-03-26 18:57:28');
INSERT INTO `bitacora_movimientos` VALUES (10574, 3388, 'productos', 'Se elimino el Id :L2S002', '2020-03-26 18:57:34');
INSERT INTO `bitacora_movimientos` VALUES (10575, 3388, 'productos', 'Se elimino el Id :MOTOX', '2020-03-26 18:57:43');
INSERT INTO `bitacora_movimientos` VALUES (10576, 3388, 'guias', 'Nuevo guia creado con el ID :', '2020-03-26 19:17:32');
INSERT INTO `bitacora_movimientos` VALUES (10577, 3388, 'guias', 'Nuevo guia creado con el ID :', '2020-03-26 19:17:52');
INSERT INTO `bitacora_movimientos` VALUES (10578, 3388, 'guias', 'Nuevo guia creado con el ID :', '2020-03-26 19:18:23');
INSERT INTO `bitacora_movimientos` VALUES (10579, 3388, 'guias', 'Nuevo guia creado con el ID :', '2020-03-26 19:18:38');
INSERT INTO `bitacora_movimientos` VALUES (10580, 3388, 'guias', 'Nuevo guia creado con el ID :', '2020-03-26 19:18:57');
INSERT INTO `bitacora_movimientos` VALUES (10581, 3388, 'guias', 'Nuevo guia creado con el ID :', '2020-03-26 19:19:22');
INSERT INTO `bitacora_movimientos` VALUES (10582, 3388, 'guias', 'Nuevo guia creado con el ID :', '2020-03-26 19:19:59');
INSERT INTO `bitacora_movimientos` VALUES (10583, 3388, 'Categorias', 'Nueva Categoria con el ID :16', '2020-03-26 19:23:38');
INSERT INTO `bitacora_movimientos` VALUES (10584, 3388, 'guias', 'Nuevo guia creado con el ID :', '2020-03-26 19:24:21');
INSERT INTO `bitacora_movimientos` VALUES (10585, 3388, 'Categorias', 'Modificamos la Categoría con el ID :15', '2020-03-26 19:25:25');
INSERT INTO `bitacora_movimientos` VALUES (10586, 3388, 'categorias', 'Se elimino el Id :14', '2020-03-26 19:25:36');
INSERT INTO `bitacora_movimientos` VALUES (10587, 3388, 'categorias', 'Se elimino el Id :13', '2020-03-26 19:25:41');
INSERT INTO `bitacora_movimientos` VALUES (10588, 3388, 'Categorias', 'Modificamos la Categoría con el ID :16', '2020-03-26 19:26:06');
INSERT INTO `bitacora_movimientos` VALUES (10589, 3388, 'Categorias', 'Modificamos la Categoría con el ID :16', '2020-03-26 19:26:39');
INSERT INTO `bitacora_movimientos` VALUES (10590, 3388, 'Categorias', 'Modificamos la Categoría con el ID :15', '2020-03-26 19:26:49');
INSERT INTO `bitacora_movimientos` VALUES (10591, 3388, 'Productos', 'Nuevo producto con el ID :70015058', '2020-03-26 19:33:11');
INSERT INTO `bitacora_movimientos` VALUES (10592, 3388, 'Productos', 'Nuevo producto con el ID :70013013', '2020-03-26 19:37:42');
INSERT INTO `bitacora_movimientos` VALUES (10593, 3388, 'Productos', 'Nuevo producto con el ID :70015509', '2020-03-26 19:42:22');
INSERT INTO `bitacora_movimientos` VALUES (10594, 3388, 'Productos', 'Nuevo producto con el ID :70015067', '2020-03-26 19:48:04');
INSERT INTO `bitacora_movimientos` VALUES (10595, 3388, 'Productos', 'Nuevo producto con el ID :70014566', '2020-03-26 19:52:20');
INSERT INTO `bitacora_movimientos` VALUES (10596, 3388, 'Productos', 'Nuevo producto con el ID :70014366', '2020-03-26 20:12:47');
INSERT INTO `bitacora_movimientos` VALUES (10597, 3388, 'Categorias', 'Nueva Categoria con el ID :17', '2020-03-26 20:15:13');
INSERT INTO `bitacora_movimientos` VALUES (10598, 3388, 'Categorias', 'Modificamos la Categoría con el ID :15', '2020-03-26 20:15:34');
INSERT INTO `bitacora_movimientos` VALUES (10599, 3388, 'Categorias', 'Modificamos la Categoría con el ID :17', '2020-03-26 20:15:45');
INSERT INTO `bitacora_movimientos` VALUES (10600, 3388, 'guias', 'Nuevo guia creado con el ID :', '2020-03-26 20:19:50');
INSERT INTO `bitacora_movimientos` VALUES (10601, 3388, 'guias', 'Nuevo guia creado con el ID :', '2020-03-26 20:25:39');
INSERT INTO `bitacora_movimientos` VALUES (10602, 3388, 'guias', 'Nuevo guia creado con el ID :', '2020-03-26 20:29:40');
INSERT INTO `bitacora_movimientos` VALUES (10603, 3388, 'Productos', 'Nuevo producto con el ID :70013498', '2020-03-26 20:31:25');
INSERT INTO `bitacora_movimientos` VALUES (10604, 3388, 'Productos', 'Nuevo producto con el ID :70014472', '2020-03-26 20:34:11');
INSERT INTO `bitacora_movimientos` VALUES (10605, 3388, 'Productos', 'Nuevo producto con el ID :70014473', '2020-03-26 20:39:22');
INSERT INTO `bitacora_movimientos` VALUES (10606, 3388, 'Productos', 'Nuevo producto con el ID :70014474', '2020-03-26 20:45:40');
INSERT INTO `bitacora_movimientos` VALUES (10607, 3389, 'Productos', 'Nuevo producto con el ID :70014084', '2020-03-26 21:56:41');
INSERT INTO `bitacora_movimientos` VALUES (10608, 3389, 'Productos', 'Nuevo producto con el ID :70013663', '2020-03-26 21:58:15');
INSERT INTO `bitacora_movimientos` VALUES (10609, 3389, 'Productos', 'Nuevo producto con el ID :70014911', '2020-03-26 22:00:37');
INSERT INTO `bitacora_movimientos` VALUES (10610, 3389, 'Productos', 'Nuevo producto con el ID :70014912', '2020-03-26 22:02:26');
INSERT INTO `bitacora_movimientos` VALUES (10611, 3389, 'Productos', 'Nuevo producto con el ID :70013462', '2020-03-26 22:08:06');
INSERT INTO `bitacora_movimientos` VALUES (10612, 3389, 'Productos', 'Nuevo producto con el ID :70013161', '2020-03-26 22:11:55');
INSERT INTO `bitacora_movimientos` VALUES (10613, 3389, 'Productos', 'Nuevo producto con el ID :70014856', '2020-03-26 22:15:08');
INSERT INTO `bitacora_movimientos` VALUES (10614, 3389, 'Productos', 'Nuevo producto con el ID :70014857', '2020-03-26 22:17:24');
INSERT INTO `bitacora_movimientos` VALUES (10615, 3389, 'Productos', 'Nuevo producto con el ID :70015005', '2020-03-26 22:22:09');
INSERT INTO `bitacora_movimientos` VALUES (10616, 3389, 'Productos', 'Nuevo producto con el ID :70015006', '2020-03-26 22:27:44');
INSERT INTO `bitacora_movimientos` VALUES (10617, 3389, 'Productos', 'Nuevo producto con el ID :70013876', '2020-03-26 22:34:34');
INSERT INTO `bitacora_movimientos` VALUES (10618, 3389, 'Productos', 'Nuevo producto con el ID :70014457', '2020-03-26 22:40:09');
INSERT INTO `bitacora_movimientos` VALUES (10619, 3389, 'Productos', 'Nuevo producto con el ID :70014456', '2020-03-26 22:46:50');
INSERT INTO `bitacora_movimientos` VALUES (10620, 3389, 'Productos', 'Nuevo producto con el ID :70015048', '2020-03-26 22:50:42');
INSERT INTO `bitacora_movimientos` VALUES (10621, 3389, 'Productos', 'Nuevo producto con el ID :70015049', '2020-03-26 22:55:10');
INSERT INTO `bitacora_movimientos` VALUES (10622, 3389, 'Productos', 'Nuevo producto con el ID :70014579', '2020-03-26 22:57:30');
INSERT INTO `bitacora_movimientos` VALUES (10623, 3389, 'Productos', 'Nuevo producto con el ID :70014580', '2020-03-26 23:02:52');
INSERT INTO `bitacora_movimientos` VALUES (10624, 3389, 'Productos', 'Nuevo producto con el ID :70013404', '2020-03-26 23:06:09');
INSERT INTO `bitacora_movimientos` VALUES (10625, 3389, 'Productos', 'Nuevo producto con el ID :70014330', '2020-03-26 23:08:38');
INSERT INTO `bitacora_movimientos` VALUES (10626, 3389, 'Productos', 'Nuevo producto con el ID :70014329', '2020-03-26 23:11:33');
INSERT INTO `bitacora_movimientos` VALUES (10627, 3389, 'guias', 'Nuevo guia creado con el ID :', '2020-03-26 23:13:10');
INSERT INTO `bitacora_movimientos` VALUES (10628, 3389, 'Productos', 'Nuevo producto con el ID :70013324', '2020-03-26 23:17:51');
INSERT INTO `bitacora_movimientos` VALUES (10629, 3389, 'Productos', 'Nuevo producto con el ID :70013126', '2020-03-26 23:21:35');
INSERT INTO `bitacora_movimientos` VALUES (10630, 3389, 'subcategoria', 'Se elimino el Id :33', '2020-03-26 23:22:10');
INSERT INTO `bitacora_movimientos` VALUES (10631, 3389, 'subcategoria', 'Se elimino el Id :34', '2020-03-26 23:22:15');
INSERT INTO `bitacora_movimientos` VALUES (10632, 3389, 'Productos', 'Nuevo producto con el ID :70013961', '2020-03-26 23:26:28');
INSERT INTO `bitacora_movimientos` VALUES (10633, 3389, 'Productos', 'Nuevo producto con el ID :70013960', '2020-03-26 23:30:05');
INSERT INTO `bitacora_movimientos` VALUES (10634, 3389, 'Productos', 'Nuevo producto con el ID :70013829', '2020-03-26 23:32:14');
INSERT INTO `bitacora_movimientos` VALUES (10635, 3389, 'Productos', 'Nuevo producto con el ID :70013667', '2020-03-26 23:36:04');
INSERT INTO `bitacora_movimientos` VALUES (10636, 3389, 'Productos', 'Nuevo producto con el ID :70014549', '2020-03-26 23:38:50');
INSERT INTO `bitacora_movimientos` VALUES (10637, 3389, 'Productos', 'Nuevo producto con el ID :70014550', '2020-03-26 23:39:47');
INSERT INTO `bitacora_movimientos` VALUES (10638, 3389, 'Productos', 'Nuevo producto con el ID :70015439', '2020-03-26 23:42:39');
INSERT INTO `bitacora_movimientos` VALUES (10639, 3389, 'Productos', 'Nuevo producto con el ID :70015440', '2020-03-26 23:44:44');
INSERT INTO `bitacora_movimientos` VALUES (10640, 3389, 'Tallas', 'Modificamos la talla con el ID :38', '2020-03-26 23:51:39');
INSERT INTO `bitacora_movimientos` VALUES (10641, 3389, 'Tallas', 'Modificamos la talla con el ID :38', '2020-03-26 23:52:25');
INSERT INTO `bitacora_movimientos` VALUES (10642, 3389, 'entradas', 'Nueva entrada con el ID :514', '2020-03-26 23:53:06');
INSERT INTO `bitacora_movimientos` VALUES (10643, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :514 IDproducto: 70015058', '2020-03-26 23:53:06');
INSERT INTO `bitacora_movimientos` VALUES (10644, 3389, 'entradas', 'Nueva entrada con el ID :515', '2020-03-26 23:58:42');
INSERT INTO `bitacora_movimientos` VALUES (10645, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :515 IDproducto: 70013013', '2020-03-26 23:58:42');
INSERT INTO `bitacora_movimientos` VALUES (10646, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :515 IDproducto: 70015509', '2020-03-26 23:58:42');
INSERT INTO `bitacora_movimientos` VALUES (10647, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :515 IDproducto: 70015067', '2020-03-26 23:58:42');
INSERT INTO `bitacora_movimientos` VALUES (10648, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :515 IDproducto: 70014566', '2020-03-26 23:58:42');
INSERT INTO `bitacora_movimientos` VALUES (10649, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :515 IDproducto: 70014366', '2020-03-26 23:58:42');
INSERT INTO `bitacora_movimientos` VALUES (10650, 3389, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-27 00:00:46');
INSERT INTO `bitacora_movimientos` VALUES (10651, 3389, 'entradas', 'Nueva entrada con el ID :516', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10652, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70013498', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10653, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70014472', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10654, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70014473', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10655, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70014474', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10656, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70014084', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10657, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70013663', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10658, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70014911', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10659, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70014912', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10660, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70013462', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10661, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70013161', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10662, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70014856', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10663, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70014857', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10664, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70015005', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10665, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70015006', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10666, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70013876', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10667, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70014457', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10668, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70014456', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10669, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70015048', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10670, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70015049', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10671, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70014579', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10672, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70014580', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10673, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70013404', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10674, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70014330', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10675, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70014329', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10676, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70013324', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10677, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70013126', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10678, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70013961', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10679, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70013960', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10680, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70013829', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10681, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70013667', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10682, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70014549', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10683, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70014550', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10684, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70015439', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10685, 3389, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :516 IDproducto: 70015440', '2020-03-27 00:14:00');
INSERT INTO `bitacora_movimientos` VALUES (10686, 3389, 'subcategoria', 'Se elimino el Id :18', '2020-03-27 00:16:14');
INSERT INTO `bitacora_movimientos` VALUES (10687, 3389, 'subcategoria', 'Se elimino el Id :19', '2020-03-27 00:16:18');
INSERT INTO `bitacora_movimientos` VALUES (10688, 3389, 'subcategoria', 'Se elimino el Id :20', '2020-03-27 00:16:21');
INSERT INTO `bitacora_movimientos` VALUES (10689, 3389, 'guias', 'Nuevo guia creado con el ID :', '2020-03-27 00:17:04');
INSERT INTO `bitacora_movimientos` VALUES (10690, 3389, 'guias', 'Nuevo guia creado con el ID :', '2020-03-27 00:17:16');
INSERT INTO `bitacora_movimientos` VALUES (10691, 3389, 'guias', 'Nuevo guia creado con el ID :', '2020-03-27 00:17:28');
INSERT INTO `bitacora_movimientos` VALUES (10692, 3389, 'guias', 'Nuevo guia creado con el ID :', '2020-03-27 00:26:48');
INSERT INTO `bitacora_movimientos` VALUES (10693, 3389, 'guias', 'Modificacion de guia creado con el ID :', '2020-03-27 00:36:23');
INSERT INTO `bitacora_movimientos` VALUES (10694, 3389, 'guias', 'Modificacion de guia creado con el ID :', '2020-03-27 00:36:31');
INSERT INTO `bitacora_movimientos` VALUES (10695, 3389, 'guias', 'Modificacion de guia creado con el ID :', '2020-03-27 00:36:39');
INSERT INTO `bitacora_movimientos` VALUES (10696, 3389, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-03-27 00:51:11');
INSERT INTO `bitacora_movimientos` VALUES (10697, 3389, 'Productos', 'Modificamos el producto con el ID :70014550', '2020-03-27 00:58:06');
INSERT INTO `bitacora_movimientos` VALUES (10698, 3391, 'Productos', 'Nuevo producto con el ID :00001', '2020-03-27 16:35:22');
INSERT INTO `bitacora_movimientos` VALUES (10699, 3391, 'Productos', 'Modificamos el producto con el ID :00001', '2020-03-27 16:37:19');
INSERT INTO `bitacora_movimientos` VALUES (10700, 3391, 'entradas', 'Nueva entrada con el ID :517', '2020-03-27 16:37:40');
INSERT INTO `bitacora_movimientos` VALUES (10701, 3391, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :517 IDproducto: 00001', '2020-03-27 16:37:40');
INSERT INTO `bitacora_movimientos` VALUES (10702, 3391, 'Productos', 'Modificamos el producto con el ID :00001', '2020-03-27 16:43:28');
INSERT INTO `bitacora_movimientos` VALUES (10703, 3391, 'etiqueta', 'Nueva Lista de etiqetas con el id :10', '2020-03-27 16:46:29');
INSERT INTO `bitacora_movimientos` VALUES (10704, 3391, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :10 IDproducto: 1', '2020-03-27 16:47:04');
INSERT INTO `bitacora_movimientos` VALUES (10705, 3391, 'etiqueta_detalles', 'Nueva etiqueta detalle con el id :10 IDproducto: 2', '2020-03-27 16:47:04');
INSERT INTO `bitacora_movimientos` VALUES (10706, 3392, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-02 11:19:56');
INSERT INTO `bitacora_movimientos` VALUES (10707, 3394, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-02 13:41:39');
INSERT INTO `bitacora_movimientos` VALUES (10708, 3394, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-02 13:48:18');
INSERT INTO `bitacora_movimientos` VALUES (10709, 3394, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-02 13:56:12');
INSERT INTO `bitacora_movimientos` VALUES (10710, 3394, 'Categorias', 'Nueva Categoria con el ID :18', '2020-04-02 13:59:00');
INSERT INTO `bitacora_movimientos` VALUES (10711, 3394, 'guias', 'Nuevo guia creado con el ID :', '2020-04-02 14:00:17');
INSERT INTO `bitacora_movimientos` VALUES (10712, 3394, 'guias', 'Nuevo guia creado con el ID :', '2020-04-02 14:01:42');
INSERT INTO `bitacora_movimientos` VALUES (10713, 3394, 'Categorias', 'Modificamos la Categoría con el ID :12', '2020-04-02 14:02:32');
INSERT INTO `bitacora_movimientos` VALUES (10714, 3394, 'Productos', 'Nuevo producto con el ID :1000', '2020-04-02 14:14:37');
INSERT INTO `bitacora_movimientos` VALUES (10715, 3394, 'entradas', 'Nueva entrada con el ID :518', '2020-04-02 14:19:03');
INSERT INTO `bitacora_movimientos` VALUES (10716, 3394, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :518 IDproducto: 1000', '2020-04-02 14:19:03');
INSERT INTO `bitacora_movimientos` VALUES (10717, 3394, 'Productos', 'Modificamos el producto con el ID :1000', '2020-04-02 14:20:18');
INSERT INTO `bitacora_movimientos` VALUES (10718, 3394, 'Productos', 'Modificamos el producto con el ID :1000', '2020-04-02 14:31:44');
INSERT INTO `bitacora_movimientos` VALUES (10719, 3397, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-02 16:39:36');
INSERT INTO `bitacora_movimientos` VALUES (10720, 3398, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-02 21:17:01');
INSERT INTO `bitacora_movimientos` VALUES (10721, 3398, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-02 21:18:59');
INSERT INTO `bitacora_movimientos` VALUES (10722, 3398, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-02 21:20:37');
INSERT INTO `bitacora_movimientos` VALUES (10723, 3398, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-02 21:21:07');
INSERT INTO `bitacora_movimientos` VALUES (10724, 3420, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-12 22:49:31');
INSERT INTO `bitacora_movimientos` VALUES (10725, 3420, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-12 22:54:28');
INSERT INTO `bitacora_movimientos` VALUES (10726, 3421, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-12 23:19:52');
INSERT INTO `bitacora_movimientos` VALUES (10727, 3421, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-12 23:20:21');
INSERT INTO `bitacora_movimientos` VALUES (10728, 3421, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-12 23:21:35');
INSERT INTO `bitacora_movimientos` VALUES (10729, 3421, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-12 23:22:29');
INSERT INTO `bitacora_movimientos` VALUES (10730, 3421, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-12 23:23:10');
INSERT INTO `bitacora_movimientos` VALUES (10731, 3421, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-12 23:23:22');
INSERT INTO `bitacora_movimientos` VALUES (10732, 3422, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-12 23:28:48');
INSERT INTO `bitacora_movimientos` VALUES (10733, 3422, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-12 23:31:52');
INSERT INTO `bitacora_movimientos` VALUES (10734, 3423, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-12 23:32:17');
INSERT INTO `bitacora_movimientos` VALUES (10735, 3422, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-12 23:37:38');
INSERT INTO `bitacora_movimientos` VALUES (10736, 3422, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-12 23:48:26');
INSERT INTO `bitacora_movimientos` VALUES (10737, 3422, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-12 23:49:02');
INSERT INTO `bitacora_movimientos` VALUES (10738, 3422, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-12 23:49:26');
INSERT INTO `bitacora_movimientos` VALUES (10739, 3422, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-12 23:51:46');
INSERT INTO `bitacora_movimientos` VALUES (10740, 3422, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-12 23:54:46');
INSERT INTO `bitacora_movimientos` VALUES (10741, 3422, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-12 23:56:31');
INSERT INTO `bitacora_movimientos` VALUES (10742, 3422, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-12 23:58:33');
INSERT INTO `bitacora_movimientos` VALUES (10743, 3425, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-17 15:35:30');
INSERT INTO `bitacora_movimientos` VALUES (10744, 3431, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-23 22:36:01');
INSERT INTO `bitacora_movimientos` VALUES (10745, 3431, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-23 22:36:18');
INSERT INTO `bitacora_movimientos` VALUES (10746, 3431, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-23 22:38:31');
INSERT INTO `bitacora_movimientos` VALUES (10747, 3432, 'Configuracion', 'Modificamos la Configuracion de la empresa-2', '2020-04-23 23:58:45');
INSERT INTO `bitacora_movimientos` VALUES (10748, 3433, 'Nota Descripcion', 'Agregamos los detalles de la Nota de remsion:2859', '2020-04-24 00:34:35');
INSERT INTO `bitacora_movimientos` VALUES (10749, 3433, 'Nota Descripcion', 'Agregamos los detalles de la Nota de remsion:2859', '2020-04-24 00:34:35');
INSERT INTO `bitacora_movimientos` VALUES (10750, 3433, 'Nota Remision', 'Agregamos una Nota de Remision:2859', '2020-04-24 00:34:35');
INSERT INTO `bitacora_movimientos` VALUES (10751, 3436, 'perfiles', 'Modificacion del perfil creado -1', '2020-05-07 03:37:44');
INSERT INTO `bitacora_movimientos` VALUES (10752, 3436, 'perfiles', 'Modificacion del perfil creado -1', '2020-05-07 03:43:23');
INSERT INTO `bitacora_movimientos` VALUES (10753, 3436, 'Administrador', 'Nuevo Usuario creado -admin', '2020-05-07 03:49:35');
INSERT INTO `bitacora_movimientos` VALUES (10754, 3446, 'perfiles', 'Se elimino el Id :6', '2020-05-07 16:40:05');
INSERT INTO `bitacora_movimientos` VALUES (10755, 3446, 'perfiles', 'Se elimino el Id :5', '2020-05-07 16:45:38');
INSERT INTO `bitacora_movimientos` VALUES (10756, 3446, 'perfiles', 'Se elimino el Id :2', '2020-05-07 16:45:53');
INSERT INTO `bitacora_movimientos` VALUES (10757, 3446, 'perfiles', 'Se elimino el Id :3', '2020-05-07 16:45:57');
INSERT INTO `bitacora_movimientos` VALUES (10758, 3446, 'perfiles', 'Se elimino el Id :4', '2020-05-07 16:46:01');
INSERT INTO `bitacora_movimientos` VALUES (10759, 3446, 'perfiles', 'Nuevo Perfil creado -7', '2020-05-07 16:47:27');
INSERT INTO `bitacora_movimientos` VALUES (10760, 3446, 'Administrador', 'Nuevo Usuario creado -prueba', '2020-05-07 16:48:51');
INSERT INTO `bitacora_movimientos` VALUES (10761, 3448, 'perfiles', 'Modificacion del perfil creado -7', '2020-05-08 04:05:37');
INSERT INTO `bitacora_movimientos` VALUES (10762, 3448, 'perfiles', 'Nuevo Perfil creado -8', '2020-05-08 04:06:24');
INSERT INTO `bitacora_movimientos` VALUES (10763, 3448, 'perfiles', 'Se elimino el Id :8', '2020-05-08 04:06:33');
INSERT INTO `bitacora_movimientos` VALUES (10764, 3448, 'perfiles', 'Nuevo Perfil creado -9', '2020-05-08 04:07:33');
INSERT INTO `bitacora_movimientos` VALUES (10765, 3448, 'perfiles', 'Se elimino el Id :9', '2020-05-08 04:07:41');
INSERT INTO `bitacora_movimientos` VALUES (10766, 3448, 'perfiles', 'Nuevo Perfil creado -10', '2020-05-08 04:09:40');
INSERT INTO `bitacora_movimientos` VALUES (10767, 3448, 'perfiles', 'Se elimino el Id :10', '2020-05-08 04:09:44');
INSERT INTO `bitacora_movimientos` VALUES (10768, 3448, 'perfiles', 'Nuevo Perfil creado -11', '2020-05-08 04:10:46');
INSERT INTO `bitacora_movimientos` VALUES (10769, 3448, 'perfiles', 'Se elimino el Id :11', '2020-05-08 04:10:51');
INSERT INTO `bitacora_movimientos` VALUES (10770, 3448, 'perfiles', 'Modificacion del perfil creado -1', '2020-05-08 06:32:29');
INSERT INTO `bitacora_movimientos` VALUES (10771, 3449, 'Configuracion', 'Modificamos la Configuracion de la empresa-1', '2020-05-08 07:29:39');
INSERT INTO `bitacora_movimientos` VALUES (10772, 3449, 'Configuracion', 'Modificamos la Configuracion de la empresa-1', '2020-05-08 07:39:14');
INSERT INTO `bitacora_movimientos` VALUES (10773, 3449, 'Configuracion', 'Modificamos la Configuracion de la empresa-1', '2020-05-08 07:45:11');
INSERT INTO `bitacora_movimientos` VALUES (10774, 3449, 'Configuracion', 'Modificamos la Configuracion de la empresa-1', '2020-05-08 07:59:47');
INSERT INTO `bitacora_movimientos` VALUES (10775, 3449, 'Configuracion', 'Modificamos la Configuracion de la empresa-1', '2020-05-08 08:03:13');
INSERT INTO `bitacora_movimientos` VALUES (10776, 3449, 'Configuracion', 'Modificamos la Configuracion de la empresa-1', '2020-05-08 08:07:07');
INSERT INTO `bitacora_movimientos` VALUES (10777, 3449, 'perfiles', 'Nuevo Perfil creado -12', '2020-05-08 14:01:03');
INSERT INTO `bitacora_movimientos` VALUES (10778, 3449, 'perfiles', 'Se elimino el Id :12', '2020-05-08 14:01:08');
INSERT INTO `bitacora_movimientos` VALUES (10779, 3449, 'usuarios', 'Se elimino el Id :28', '2020-05-08 14:22:50');
INSERT INTO `bitacora_movimientos` VALUES (10780, 3449, 'perfiles', 'Se elimino el Id :7', '2020-05-08 14:22:56');
INSERT INTO `bitacora_movimientos` VALUES (10781, 3449, 'perfiles', 'Modificacion del perfil creado -1', '2020-05-08 14:32:13');
INSERT INTO `bitacora_movimientos` VALUES (10782, 3449, 'perfiles', 'Modificacion del perfil creado -1', '2020-05-08 14:33:06');
INSERT INTO `bitacora_movimientos` VALUES (10783, 3449, 'perfiles', 'Nuevo Perfil creado -13', '2020-05-08 14:34:21');
INSERT INTO `bitacora_movimientos` VALUES (10784, 3449, 'perfiles', 'Modificacion del perfil creado -13', '2020-05-08 14:36:09');
INSERT INTO `bitacora_movimientos` VALUES (10785, 3449, 'perfiles', 'Modificacion del perfil creado -13', '2020-05-08 14:36:36');
INSERT INTO `bitacora_movimientos` VALUES (10786, 3449, 'perfiles', 'Se elimino el Id :13', '2020-05-08 14:36:42');
INSERT INTO `bitacora_movimientos` VALUES (10787, 3449, 'Administrador', 'Modificación de Usuario -admin', '2020-05-08 14:39:52');
INSERT INTO `bitacora_movimientos` VALUES (10788, 3449, 'Administrador', 'Nuevo Usuario creado -123', '2020-05-08 14:40:18');
INSERT INTO `bitacora_movimientos` VALUES (10789, 3449, 'usuarios', 'Se elimino el Id :29', '2020-05-08 14:40:23');
INSERT INTO `bitacora_movimientos` VALUES (10790, 3449, 'sucursales', 'Modifico Sucursal con ID: -1', '2020-05-08 16:17:08');
INSERT INTO `bitacora_movimientos` VALUES (10791, 3449, 'sucursales', 'Modifico Sucursal con ID: -1', '2020-05-08 16:21:03');
INSERT INTO `bitacora_movimientos` VALUES (10792, 3449, 'sucursales', 'Nueva Sucursal creada -3', '2020-05-08 16:39:51');
INSERT INTO `bitacora_movimientos` VALUES (10793, 3449, 'sucursales', 'Modifico Sucursal con ID: -1', '2020-05-08 16:44:32');
INSERT INTO `bitacora_movimientos` VALUES (10794, 3459, 'sucursales', 'Se elimino el Id :3', '2020-05-09 18:10:07');
INSERT INTO `bitacora_movimientos` VALUES (10795, 3466, 'Administrador', 'Modificación de Usuario -al02638387', '2020-05-10 05:45:05');
INSERT INTO `bitacora_movimientos` VALUES (10796, 3466, 'sucursales', 'Modifico Sucursal con ID: -1', '2020-05-10 05:46:20');
INSERT INTO `bitacora_movimientos` VALUES (10797, 3468, 'perfiles', 'Nuevo Perfil creado -14', '2020-05-10 14:31:28');
INSERT INTO `bitacora_movimientos` VALUES (10798, 3468, 'perfiles', 'Modificacion del perfil creado -14', '2020-05-10 14:31:38');
INSERT INTO `bitacora_movimientos` VALUES (10799, 3468, 'perfiles', 'Modificacion del perfil creado -14', '2020-05-10 14:32:45');
INSERT INTO `bitacora_movimientos` VALUES (10800, 3468, 'perfiles', 'Se elimino el Id :14', '2020-05-10 14:32:49');
INSERT INTO `bitacora_movimientos` VALUES (10801, 3468, 'Configuracion', 'Modificamos la Configuracion de la empresa-1', '2020-05-10 14:39:04');
INSERT INTO `bitacora_movimientos` VALUES (10802, 3468, 'perfiles', 'Modificacion del perfil creado -1', '2020-05-10 21:08:33');
INSERT INTO `bitacora_movimientos` VALUES (10803, 3468, 'Proveedores', 'Modificamos el Proveedor con el ID :3', '2020-05-10 22:06:59');
INSERT INTO `bitacora_movimientos` VALUES (10804, 3468, 'Proveedores', 'Nuevo Proveedor creado con el ID :4', '2020-05-10 22:10:47');
INSERT INTO `bitacora_movimientos` VALUES (10805, 3468, 'proveedores', 'Se elimino el Id :4', '2020-05-10 22:10:52');
INSERT INTO `bitacora_movimientos` VALUES (10806, 3468, 'clientes', 'Se elimino el Id :4132', '2020-05-11 01:33:32');
INSERT INTO `bitacora_movimientos` VALUES (10807, 3468, 'clientes', 'Se elimino el Id :4119', '2020-05-11 01:33:51');
INSERT INTO `bitacora_movimientos` VALUES (10808, 3474, 'Clientes', 'Modificar Cliente con el ID :4114', '2020-05-12 22:52:18');
INSERT INTO `bitacora_movimientos` VALUES (10809, 3474, 'Proveedores', 'Modificamos el Proveedor con el ID :3', '2020-05-12 23:13:17');
INSERT INTO `bitacora_movimientos` VALUES (10810, 3476, 'Clientes', 'Modificar Cliente con el ID :4114', '2020-05-13 19:25:10');
INSERT INTO `bitacora_movimientos` VALUES (10811, 3476, 'Clientes', 'Modificar Cliente con el ID :4114', '2020-05-13 19:25:42');
INSERT INTO `bitacora_movimientos` VALUES (10812, 3476, 'Clientes', 'Modificar Cliente con el ID :4114', '2020-05-13 19:26:29');
INSERT INTO `bitacora_movimientos` VALUES (10813, 3476, 'Clientes', 'Modificar Cliente con el ID :4114', '2020-05-13 19:27:31');
INSERT INTO `bitacora_movimientos` VALUES (10814, 3476, 'clientes', 'Se elimino el Id :4114', '2020-05-13 19:29:08');
INSERT INTO `bitacora_movimientos` VALUES (10815, 3476, 'clientes', 'Se elimino el Id :4120', '2020-05-13 19:29:13');
INSERT INTO `bitacora_movimientos` VALUES (10816, 3476, 'clientes', 'Se elimino el Id :4121', '2020-05-13 19:29:17');
INSERT INTO `bitacora_movimientos` VALUES (10817, 3476, 'clientes', 'Se elimino el Id :4127', '2020-05-13 19:29:25');
INSERT INTO `bitacora_movimientos` VALUES (10818, 3476, 'clientes', 'Se elimino el Id :4128', '2020-05-13 19:29:28');
INSERT INTO `bitacora_movimientos` VALUES (10819, 3476, 'clientes', 'Se elimino el Id :4129', '2020-05-13 19:29:31');
INSERT INTO `bitacora_movimientos` VALUES (10820, 3476, 'clientes', 'Se elimino el Id :4133', '2020-05-13 19:29:37');
INSERT INTO `bitacora_movimientos` VALUES (10821, 3476, 'clientes', 'Se elimino el Id :4134', '2020-05-13 19:29:41');
INSERT INTO `bitacora_movimientos` VALUES (10822, 3476, 'clientes', 'Se elimino el Id :4131', '2020-05-13 19:29:45');
INSERT INTO `bitacora_movimientos` VALUES (10823, 3476, 'clientes', 'Se elimino el Id :4130', '2020-05-13 19:29:49');
INSERT INTO `bitacora_movimientos` VALUES (10824, 3476, 'clientes', 'Se elimino el Id :4124', '2020-05-13 19:29:56');
INSERT INTO `bitacora_movimientos` VALUES (10825, 3476, 'clientes', 'Se elimino el Id :4123', '2020-05-13 19:30:00');
INSERT INTO `bitacora_movimientos` VALUES (10826, 3476, 'clientes', 'Se elimino el Id :4122', '2020-05-13 19:30:08');
INSERT INTO `bitacora_movimientos` VALUES (10827, 3476, 'clientes', 'Se elimino el Id :4126', '2020-05-13 19:30:12');
INSERT INTO `bitacora_movimientos` VALUES (10828, 3476, 'Clientes', 'Nuevo Cliente creado con el ID :4135', '2020-05-13 22:03:42');
INSERT INTO `bitacora_movimientos` VALUES (10829, 3476, 'Clientes', 'Modificar Cliente con el ID :4135', '2020-05-13 22:04:03');
INSERT INTO `bitacora_movimientos` VALUES (10830, 3476, 'Clientes', 'Modificar Cliente con el ID :4135', '2020-05-13 22:04:26');
INSERT INTO `bitacora_movimientos` VALUES (10831, 3477, 'Proveedores', 'Modificamos el Proveedor con el ID :3', '2020-05-13 22:56:01');
INSERT INTO `bitacora_movimientos` VALUES (10832, 3477, 'perfiles', 'Modificacion del perfil creado -1', '2020-05-13 23:59:03');
INSERT INTO `bitacora_movimientos` VALUES (10833, 3477, 'perfiles', 'Modificacion del perfil creado -1', '2020-05-14 00:00:34');
INSERT INTO `bitacora_movimientos` VALUES (10834, 3477, 'Catalogos', 'Nueva Categoria de precio creada con el ID :10', '2020-05-14 00:05:40');
INSERT INTO `bitacora_movimientos` VALUES (10835, 3477, 'Catalogos', 'Nueva Categoria de precio creada con el ID :11', '2020-05-14 00:08:27');
INSERT INTO `bitacora_movimientos` VALUES (10836, 3477, 'Categorias', 'Modificamos Categorias precio con el ID :11', '2020-05-14 00:09:01');
INSERT INTO `bitacora_movimientos` VALUES (10837, 3477, 'Categorias', 'Modificamos Categorias precio con el ID :10', '2020-05-14 00:09:16');
INSERT INTO `bitacora_movimientos` VALUES (10838, 3477, 'categoria_precio', 'Se elimino el Id :11', '2020-05-14 00:11:36');
INSERT INTO `bitacora_movimientos` VALUES (10839, 3477, 'Categorias', 'Modificamos Categorias precio con el ID :7', '2020-05-14 00:11:58');
INSERT INTO `bitacora_movimientos` VALUES (10840, 3477, 'Categorias', 'Modificamos Categorias precio con el ID :10', '2020-05-14 00:12:48');
INSERT INTO `bitacora_movimientos` VALUES (10841, 3477, 'Categorias', 'Modificamos Categorias precio con el ID :10', '2020-05-14 00:13:00');
INSERT INTO `bitacora_movimientos` VALUES (10842, 3477, 'Categorias', 'Modificamos Categorias precio con el ID :10', '2020-05-14 00:14:48');
INSERT INTO `bitacora_movimientos` VALUES (10843, 3477, 'Categorias', 'Modificamos Categorias precio con el ID :10', '2020-05-14 00:15:52');
INSERT INTO `bitacora_movimientos` VALUES (10844, 3477, 'Categorias', 'Modificamos Categorias precio con el ID :10', '2020-05-14 00:16:06');
INSERT INTO `bitacora_movimientos` VALUES (10845, 3477, 'Categorias', 'Modificamos Categorias precio con el ID :10', '2020-05-14 00:16:19');
INSERT INTO `bitacora_movimientos` VALUES (10846, 3477, 'Categorias', 'Modificamos Categorias precio con el ID :10', '2020-05-14 00:16:32');
INSERT INTO `bitacora_movimientos` VALUES (10847, 3477, 'categoria_precio', 'Se elimino el Id :10', '2020-05-14 00:16:39');
INSERT INTO `bitacora_movimientos` VALUES (10848, 3477, 'perfiles', 'Modificacion del perfil creado -1', '2020-05-14 00:17:15');
INSERT INTO `bitacora_movimientos` VALUES (10849, 3477, 'Administrador', 'Modificación de Usuario -al02638387', '2020-05-14 00:17:39');
INSERT INTO `bitacora_movimientos` VALUES (10850, 3477, 'Configuracion', 'Modificamos la Configuracion de la empresa-1', '2020-05-14 00:17:58');
INSERT INTO `bitacora_movimientos` VALUES (10851, 3477, 'sucursales', 'Modifico Sucursal con ID: -1', '2020-05-14 00:18:02');
INSERT INTO `bitacora_movimientos` VALUES (10852, 3477, 'Clientes', 'Modificar Cliente con el ID :4135', '2020-05-14 00:19:04');
INSERT INTO `bitacora_movimientos` VALUES (10853, 3477, 'Clientes', 'Modificar Cliente con el ID :4135', '2020-05-14 00:20:57');
INSERT INTO `bitacora_movimientos` VALUES (10854, 3477, 'clientes', 'Se elimino el Id :4125', '2020-05-14 00:21:04');
INSERT INTO `bitacora_movimientos` VALUES (10855, 3477, 'Catalogos', 'Nueva Categoria de precio creada con el ID :12', '2020-05-14 00:21:15');
INSERT INTO `bitacora_movimientos` VALUES (10856, 3477, 'categoria_precio', 'Se elimino el Id :12', '2020-05-14 00:21:39');
INSERT INTO `bitacora_movimientos` VALUES (10857, 3477, 'Catalogos', 'Nueva Categoria de precio creada con el ID :13', '2020-05-14 00:26:21');
INSERT INTO `bitacora_movimientos` VALUES (10858, 3477, 'categoria_precio', 'Se elimino el Id :13', '2020-05-14 00:27:38');
INSERT INTO `bitacora_movimientos` VALUES (10859, 3477, 'Catalogos', 'Nueva Categoria de precio creada con el ID :14', '2020-05-14 00:29:19');
INSERT INTO `bitacora_movimientos` VALUES (10860, 3477, 'categoria_precio', 'Se elimino el Id :14', '2020-05-14 00:30:02');
INSERT INTO `bitacora_movimientos` VALUES (10861, 3477, 'Catalogos', 'Nueva Categoria de precio creada con el ID :15', '2020-05-14 00:30:14');
INSERT INTO `bitacora_movimientos` VALUES (10862, 3477, 'categoria_precio', 'Se elimino el Id :15', '2020-05-14 00:30:39');
INSERT INTO `bitacora_movimientos` VALUES (10863, 3477, 'Catalogos', 'Nueva Categoria de precio creada con el ID :16', '2020-05-14 00:30:57');
INSERT INTO `bitacora_movimientos` VALUES (10864, 3477, 'categoria_precio', 'Se elimino el Id :16', '2020-05-14 00:31:59');
INSERT INTO `bitacora_movimientos` VALUES (10865, 3477, 'Catalogos', 'Nueva Categoria de precio creada con el ID :17', '2020-05-14 00:32:07');
INSERT INTO `bitacora_movimientos` VALUES (10866, 3477, 'categoria_precio', 'Se elimino el Id :17', '2020-05-14 00:33:49');
INSERT INTO `bitacora_movimientos` VALUES (10867, 3477, 'Catalogos', 'Nueva Categoria de precio creada con el ID :18', '2020-05-14 00:33:57');
INSERT INTO `bitacora_movimientos` VALUES (10868, 3477, 'categoria_precio', 'Se elimino el Id :18', '2020-05-14 00:35:04');
INSERT INTO `bitacora_movimientos` VALUES (10869, 3477, 'Catalogos', 'Nueva Categoria de precio creada con el ID :19', '2020-05-14 00:35:12');
INSERT INTO `bitacora_movimientos` VALUES (10870, 3477, 'categoria_precio', 'Se elimino el Id :19', '2020-05-14 00:36:01');
INSERT INTO `bitacora_movimientos` VALUES (10871, 3477, 'Catalogos', 'Nueva Categoria de precio creada con el ID :20', '2020-05-14 00:36:08');
INSERT INTO `bitacora_movimientos` VALUES (10872, 3477, 'categoria_precio', 'Se elimino el Id :20', '2020-05-14 00:40:40');
INSERT INTO `bitacora_movimientos` VALUES (10873, 3477, 'Catalogos', 'Nueva Categoria de precio creada con el ID :21', '2020-05-14 00:40:48');
INSERT INTO `bitacora_movimientos` VALUES (10874, 3477, 'Categorias', 'Modificamos Categorias precio con el ID :21', '2020-05-14 00:41:42');
INSERT INTO `bitacora_movimientos` VALUES (10875, 3477, 'categoria_precio', 'Se elimino el Id :21', '2020-05-14 00:41:47');
INSERT INTO `bitacora_movimientos` VALUES (10876, 3477, 'Catalogos', 'Nueva Categoria de precio creada con el ID :22', '2020-05-14 00:41:55');
INSERT INTO `bitacora_movimientos` VALUES (10877, 3477, 'categoria_precio', 'Se elimino el Id :22', '2020-05-14 00:42:09');
INSERT INTO `bitacora_movimientos` VALUES (10878, 3477, 'Catalogos', 'Nueva Categoria de precio creada con el ID :23', '2020-05-14 00:43:00');
INSERT INTO `bitacora_movimientos` VALUES (10879, 3477, 'Catalogos', 'Nueva Categoria de precio creada con el ID :24', '2020-05-14 00:43:58');
INSERT INTO `bitacora_movimientos` VALUES (10880, 3477, 'categoria_precio', 'Se elimino el Id :24', '2020-05-14 00:44:04');
INSERT INTO `bitacora_movimientos` VALUES (10881, 3477, 'categoria_precio', 'Se elimino el Id :23', '2020-05-14 00:44:11');
INSERT INTO `bitacora_movimientos` VALUES (10882, 3477, 'Catalogos', 'Nueva Categoria de precio creada con el ID :25', '2020-05-14 00:44:56');
INSERT INTO `bitacora_movimientos` VALUES (10883, 3477, 'categoria_precio', 'Se elimino el Id :25', '2020-05-14 00:45:05');
INSERT INTO `bitacora_movimientos` VALUES (10884, 3477, 'Catalogos', 'Nueva Categoria de precio creada con el ID :26', '2020-05-14 00:45:16');
INSERT INTO `bitacora_movimientos` VALUES (10885, 3477, 'categoria_precio', 'Se elimino el Id :26', '2020-05-14 00:45:27');
INSERT INTO `bitacora_movimientos` VALUES (10886, 3477, 'perfiles', 'Modificacion del perfil creado -1', '2020-05-14 01:05:55');
INSERT INTO `bitacora_movimientos` VALUES (10887, 3477, 'perfiles', 'Modificacion del perfil creado -1', '2020-05-14 01:08:45');
INSERT INTO `bitacora_movimientos` VALUES (10888, 3477, 'perfiles', 'Modificacion del perfil creado -1', '2020-05-14 01:08:53');
INSERT INTO `bitacora_movimientos` VALUES (10889, 3477, 'perfiles', 'Modificacion del perfil creado -1', '2020-05-14 01:11:05');
INSERT INTO `bitacora_movimientos` VALUES (10890, 3477, 'perfiles', 'Modificacion del perfil creado -1', '2020-05-14 01:11:14');
INSERT INTO `bitacora_movimientos` VALUES (10891, 3477, 'perfiles', 'Modificacion del perfil creado -1', '2020-05-14 01:13:38');
INSERT INTO `bitacora_movimientos` VALUES (10892, 3477, 'Catalogos', 'Nueva Categoria de precio creada con el ID :27', '2020-05-14 01:21:53');
INSERT INTO `bitacora_movimientos` VALUES (10893, 3477, 'Categorias', 'Modificamos Categorias precio con el ID :27', '2020-05-14 01:22:04');
INSERT INTO `bitacora_movimientos` VALUES (10894, 3477, 'categoria_precio', 'Se elimino el Id :27', '2020-05-14 01:22:10');
INSERT INTO `bitacora_movimientos` VALUES (10895, 3477, 'perfiles', 'Modificacion del perfil creado -1', '2020-05-14 01:31:49');
INSERT INTO `bitacora_movimientos` VALUES (10896, 3477, 'perfiles', 'Modificacion del perfil creado -1', '2020-05-14 01:32:17');
INSERT INTO `bitacora_movimientos` VALUES (10897, 3477, 'perfiles', 'Modificacion del perfil creado -1', '2020-05-14 01:33:15');
INSERT INTO `bitacora_movimientos` VALUES (10898, 3478, 'Nivel', 'Nueva Nivel creado con el ID :10', '2020-05-14 02:44:34');
INSERT INTO `bitacora_movimientos` VALUES (10899, 3478, 'niveles', 'Se elimino el Id :10', '2020-05-14 02:44:40');
INSERT INTO `bitacora_movimientos` VALUES (10900, 3478, 'Nivel', 'Nueva Nivel creado con el ID :11', '2020-05-14 02:44:47');
INSERT INTO `bitacora_movimientos` VALUES (10901, 3478, 'niveles', 'Modificamos Nivel con el ID :11', '2020-05-14 02:45:03');
INSERT INTO `bitacora_movimientos` VALUES (10902, 3478, 'niveles', 'Se elimino el Id :11', '2020-05-14 02:45:08');
INSERT INTO `bitacora_movimientos` VALUES (10903, 3479, 'Catalogos', 'Nueva Categoria de precio por nivel creada con el ID :0', '2020-05-14 13:04:55');
INSERT INTO `bitacora_movimientos` VALUES (10904, 3479, 'Catalogos', 'Nueva Categoria de precio por nivel creada con el ID :0', '2020-05-14 13:11:54');
INSERT INTO `bitacora_movimientos` VALUES (10905, 3479, 'Catalogos', 'Modifico Categoria de precio por nivel creada con el ID :', '2020-05-14 13:15:34');
INSERT INTO `bitacora_movimientos` VALUES (10906, 3479, 'Catalogos', 'Nueva Categoria de precio por nivel creada con el ID :0', '2020-05-14 13:15:56');
INSERT INTO `bitacora_movimientos` VALUES (10907, 3479, 'Catalogos', 'Modifico Categoria de precio por nivel creada con el ID :', '2020-05-14 13:16:08');
INSERT INTO `bitacora_movimientos` VALUES (10908, 3481, 'Catalogos', 'Elimino Categoria de precio por nivel creada con el IDCAT :7 Y idniveles: 7', '2020-05-14 19:34:11');
INSERT INTO `bitacora_movimientos` VALUES (10909, 3481, 'Catalogos', 'Elimino Categoria de precio por nivel creada con el IDCAT :9 Y idniveles: 8', '2020-05-14 19:39:22');
INSERT INTO `bitacora_movimientos` VALUES (10910, 3481, 'Catalogos', 'Elimino Categoria de precio por nivel creada con el IDCAT :8 Y idniveles: 9', '2020-05-14 19:41:17');
INSERT INTO `bitacora_movimientos` VALUES (10911, 3481, 'Catalogos', 'Elimino Categoria de precio por nivel creada con el IDCAT :7 Y idniveles: 9', '2020-05-14 19:41:40');
INSERT INTO `bitacora_movimientos` VALUES (10912, 3481, 'Catalogos', 'Elimino Categoria de precio por nivel creada con el IDCAT :7 Y idniveles: 8', '2020-05-14 19:41:50');
INSERT INTO `bitacora_movimientos` VALUES (10913, 3481, 'perfiles', 'Modificacion del perfil creado -1', '2020-05-14 20:59:47');
INSERT INTO `bitacora_movimientos` VALUES (10914, 3481, 'paqueterias', 'Se elimino el Id :6', '2020-05-14 21:30:18');
INSERT INTO `bitacora_movimientos` VALUES (10915, 3484, 'paqueterias', 'Modificacion de paqueteria con el ID :4', '2020-05-17 04:18:52');
INSERT INTO `bitacora_movimientos` VALUES (10916, 3486, 'gastos_categorias', 'Se elimino el Id :1', '2020-05-19 08:47:51');
INSERT INTO `bitacora_movimientos` VALUES (10917, 3486, 'Gastos', 'se agrego una nuevo concepto de gasto con el id 2', '2020-05-19 09:15:08');
INSERT INTO `bitacora_movimientos` VALUES (10918, 3486, 'Gastos', 'se agrego una nuevo concepto de gasto con el id 3', '2020-05-19 09:15:43');
INSERT INTO `bitacora_movimientos` VALUES (10919, 3486, 'gastos_categorias', 'Se elimino el Id :2', '2020-05-19 09:15:50');
INSERT INTO `bitacora_movimientos` VALUES (10920, 3486, 'Gastos', 'se Modifico una nuevo concepto de gasto con el id ', '2020-05-19 09:17:41');
INSERT INTO `bitacora_movimientos` VALUES (10921, 3486, 'Gastos', 'se Modifico una nuevo concepto de gasto con el id ', '2020-05-19 09:17:55');
INSERT INTO `bitacora_movimientos` VALUES (10922, 3486, 'Gastos', 'se Modifico una nuevo concepto de gasto con el id 3', '2020-05-19 09:19:33');
INSERT INTO `bitacora_movimientos` VALUES (10923, 3486, 'Gastos', 'se Modifico una nuevo concepto de gasto con el id 3', '2020-05-19 09:22:50');
INSERT INTO `bitacora_movimientos` VALUES (10924, 3486, 'Gastos', 'se Modifico una nuevo concepto de gasto con el id 3', '2020-05-19 09:23:24');
INSERT INTO `bitacora_movimientos` VALUES (10925, 3486, 'gastos_categorias', 'Se elimino el Id :3', '2020-05-19 09:33:42');
INSERT INTO `bitacora_movimientos` VALUES (10926, 3486, 'Gastos', 'se agrego una nuevo concepto de gasto con el id 4', '2020-05-19 09:34:06');
INSERT INTO `bitacora_movimientos` VALUES (10927, 3486, 'subcategoria', 'Se elimino el Id :28', '2020-05-19 18:15:36');
INSERT INTO `bitacora_movimientos` VALUES (10928, 3486, 'Categorias', 'Modificamos la Categor?a con el ID :12', '2020-05-19 19:43:29');
INSERT INTO `bitacora_movimientos` VALUES (10929, 3486, 'Categorias', 'Modificamos la Categor?a con el ID :12', '2020-05-19 19:43:58');
INSERT INTO `bitacora_movimientos` VALUES (10930, 3486, 'Categorias', 'Nueva Categoria con el ID :19', '2020-05-19 19:44:20');
INSERT INTO `bitacora_movimientos` VALUES (10931, 3486, 'categorias', 'Se elimino el Id :19', '2020-05-19 19:44:24');
INSERT INTO `bitacora_movimientos` VALUES (10932, 3486, 'Categorias', 'Nueva Categoria con el ID :20', '2020-05-19 19:44:53');
INSERT INTO `bitacora_movimientos` VALUES (10933, 3486, 'Categorias', 'Modificamos la Categor?a con el ID :20', '2020-05-19 19:45:02');
INSERT INTO `bitacora_movimientos` VALUES (10934, 3486, 'categorias', 'Se elimino el Id :20', '2020-05-19 19:45:12');
INSERT INTO `bitacora_movimientos` VALUES (10935, 3487, 'guias', 'Nuevo guia creado con el ID :', '2020-05-19 23:32:59');
INSERT INTO `bitacora_movimientos` VALUES (10936, 3487, 'guias', 'Nuevo guia creado con el ID :', '2020-05-19 23:35:35');
INSERT INTO `bitacora_movimientos` VALUES (10937, 3487, 'guias', 'Nuevo guia creado con el ID :', '2020-05-19 23:38:06');
INSERT INTO `bitacora_movimientos` VALUES (10938, 3487, 'subcategoria', 'Se elimino el Id :45', '2020-05-19 23:38:12');
INSERT INTO `bitacora_movimientos` VALUES (10939, 3487, 'guias', 'Nuevo guia creado con el ID :', '2020-05-19 23:38:20');
INSERT INTO `bitacora_movimientos` VALUES (10940, 3487, 'subcategoria', 'Se elimino el Id :46', '2020-05-19 23:39:32');
INSERT INTO `bitacora_movimientos` VALUES (10941, 3487, 'guias', 'Modificacion de guia creado con el ID :', '2020-05-19 23:39:43');
INSERT INTO `bitacora_movimientos` VALUES (10942, 3487, 'subcategoria', 'Modificacion de subcategoria creado con el ID :36', '2020-05-19 23:40:49');
INSERT INTO `bitacora_movimientos` VALUES (10943, 3487, 'subcategoria', 'Modificacion de subcategoria creado con el ID :15', '2020-05-19 23:44:31');
INSERT INTO `bitacora_movimientos` VALUES (10944, 3487, 'subcategoria', 'Modificacion de subcategoria creado con el ID :16', '2020-05-19 23:44:39');
INSERT INTO `bitacora_movimientos` VALUES (10945, 3487, 'subcategoria', 'NuevA subcategoria creado con el ID :47', '2020-05-19 23:44:45');
INSERT INTO `bitacora_movimientos` VALUES (10946, 3487, 'subcategoria', 'Se elimino el Id :47', '2020-05-19 23:44:51');
INSERT INTO `bitacora_movimientos` VALUES (10947, 3487, 'subcategoria', 'Modificacion de subcategoria creado con el ID :15', '2020-05-19 23:45:57');
INSERT INTO `bitacora_movimientos` VALUES (10948, 3487, 'subcategoria', 'Modificacion de subcategoria creado con el ID :17', '2020-05-19 23:46:54');
INSERT INTO `bitacora_movimientos` VALUES (10949, 3487, 'Categorias', 'Modificamos la Categor?a con el ID :16', '2020-05-19 23:47:29');
INSERT INTO `bitacora_movimientos` VALUES (10950, 3487, 'Categorias', 'Modificamos la Categor?a con el ID :12', '2020-05-19 23:47:57');
INSERT INTO `bitacora_movimientos` VALUES (10951, 3488, 'perfiles', 'Modificacion del perfil creado -1', '2020-05-20 05:29:04');
INSERT INTO `bitacora_movimientos` VALUES (10952, 3488, 'perfiles', 'Modificacion del perfil creado -1', '2020-05-20 05:29:35');
INSERT INTO `bitacora_movimientos` VALUES (10953, 3488, 'Categorias', 'Nueva Categoria con el ID :21', '2020-05-20 05:30:59');
INSERT INTO `bitacora_movimientos` VALUES (10954, 3488, 'subcategoria', 'NuevA subcategoria creado con el ID :48', '2020-05-20 05:31:53');
INSERT INTO `bitacora_movimientos` VALUES (10955, 3488, 'subcategoria', 'Se elimino el Id :48', '2020-05-20 05:31:59');
INSERT INTO `bitacora_movimientos` VALUES (10956, 3488, 'perfiles', 'Modificacion del perfil creado -1', '2020-05-20 05:55:33');
INSERT INTO `bitacora_movimientos` VALUES (10957, 3488, 'perfiles', 'Modificacion del perfil creado -1', '2020-05-20 08:00:14');
INSERT INTO `bitacora_movimientos` VALUES (10958, 3488, 'productos', 'Se elimino el Id :70015509', '2020-05-20 08:39:28');
INSERT INTO `bitacora_movimientos` VALUES (10959, 3489, 'productos', 'Se elimino el Id :01', '2020-05-21 03:37:21');
INSERT INTO `bitacora_movimientos` VALUES (10960, 3489, 'productos', 'Se elimino el Id :70013667', '2020-05-21 03:37:38');
INSERT INTO `bitacora_movimientos` VALUES (10961, 3489, 'subcategoria', 'Se elimino el Id :44', '2020-05-21 03:45:27');
INSERT INTO `bitacora_movimientos` VALUES (10962, 3489, 'subcategoria', 'Modificacion de subcategoria creado con el ID :41', '2020-05-21 03:45:42');
INSERT INTO `bitacora_movimientos` VALUES (10963, 3489, 'Productos', 'Modificamos el producto con el ID :1000', '2020-05-21 03:57:49');
INSERT INTO `bitacora_movimientos` VALUES (10964, 3489, 'Productos', 'Modificamos el producto con el ID :1000', '2020-05-21 03:58:20');
INSERT INTO `bitacora_movimientos` VALUES (10965, 3489, 'Productos', 'Modificamos el producto con el ID :1000', '2020-05-21 03:59:40');
INSERT INTO `bitacora_movimientos` VALUES (10966, 3489, 'Productos', 'Modificamos el producto con el ID :1000', '2020-05-21 04:02:17');
INSERT INTO `bitacora_movimientos` VALUES (10967, 3489, 'Productos', 'Modificamos el producto con el ID :1000', '2020-05-21 04:02:56');
INSERT INTO `bitacora_movimientos` VALUES (10968, 3489, 'Productos', 'Modificamos el producto con el ID :1000', '2020-05-21 04:04:16');
INSERT INTO `bitacora_movimientos` VALUES (10969, 3489, 'Productos', 'Modificamos el producto con el ID :1000', '2020-05-21 04:05:03');
INSERT INTO `bitacora_movimientos` VALUES (10972, 3490, 'Productos', 'Modificamos el producto con el ID :1000', '2020-05-21 04:38:50');
INSERT INTO `bitacora_movimientos` VALUES (10973, 3490, 'productos', 'Se elimino el Id :1000', '2020-05-21 04:40:32');
INSERT INTO `bitacora_movimientos` VALUES (10974, 3490, 'productos', 'Se elimino el Id :70013013', '2020-05-21 04:40:37');
INSERT INTO `bitacora_movimientos` VALUES (10975, 3490, 'productos', 'Se elimino el Id :70013126', '2020-05-21 04:41:39');
INSERT INTO `bitacora_movimientos` VALUES (10976, 3490, 'productos', 'Se elimino el Id :70013161', '2020-05-21 04:41:42');
INSERT INTO `bitacora_movimientos` VALUES (10977, 3490, 'productos', 'Se elimino el Id :70013324', '2020-05-21 04:41:46');
INSERT INTO `bitacora_movimientos` VALUES (10978, 3490, 'productos', 'Se elimino el Id :70013404', '2020-05-21 04:41:50');
INSERT INTO `bitacora_movimientos` VALUES (10979, 3490, 'productos', 'Se elimino el Id :70013462', '2020-05-21 04:41:53');
INSERT INTO `bitacora_movimientos` VALUES (10980, 3490, 'productos', 'Se elimino el Id :70013498', '2020-05-21 04:41:57');
INSERT INTO `bitacora_movimientos` VALUES (10981, 3490, 'productos', 'Se elimino el Id :70013663', '2020-05-21 04:42:00');
INSERT INTO `bitacora_movimientos` VALUES (10982, 3490, 'productos', 'Se elimino el Id :70013829', '2020-05-21 04:42:03');
INSERT INTO `bitacora_movimientos` VALUES (10983, 3490, 'categorias', 'Se elimino el Id :12', '2020-05-21 04:42:30');
INSERT INTO `bitacora_movimientos` VALUES (10984, 3490, 'categorias', 'Se elimino el Id :15', '2020-05-21 04:42:33');
INSERT INTO `bitacora_movimientos` VALUES (10985, 3490, 'categorias', 'Se elimino el Id :16', '2020-05-21 04:42:37');
INSERT INTO `bitacora_movimientos` VALUES (10986, 3490, 'categorias', 'Se elimino el Id :17', '2020-05-21 04:42:40');
INSERT INTO `bitacora_movimientos` VALUES (10987, 3490, 'categorias', 'Se elimino el Id :18', '2020-05-21 04:42:42');
INSERT INTO `bitacora_movimientos` VALUES (10988, 3490, 'categorias', 'Se elimino el Id :21', '2020-05-21 04:42:46');
INSERT INTO `bitacora_movimientos` VALUES (10989, 3490, 'Categorias', 'Nueva Categoria con el ID :22', '2020-05-21 04:42:58');
INSERT INTO `bitacora_movimientos` VALUES (10990, 3490, 'Categorias', 'Nueva Categoria con el ID :23', '2020-05-21 04:43:10');
INSERT INTO `bitacora_movimientos` VALUES (10991, 3490, 'subcategoria', 'NuevA subcategoria creado con el ID :49', '2020-05-21 04:43:30');
INSERT INTO `bitacora_movimientos` VALUES (10992, 3490, 'Productos', 'Nuevo producto con el ID :1000', '2020-05-21 04:45:17');
INSERT INTO `bitacora_movimientos` VALUES (10993, 3490, 'Productos', 'Modificamos el producto con el ID :1000', '2020-05-21 04:46:26');
INSERT INTO `bitacora_movimientos` VALUES (10994, 3490, 'Productos', 'Modificamos el producto con el ID :1000', '2020-05-21 04:47:36');
INSERT INTO `bitacora_movimientos` VALUES (10995, 3490, 'Catalogos', 'Nueva Categoria de precio por nivel creada con el ID :0', '2020-05-21 06:09:20');
INSERT INTO `bitacora_movimientos` VALUES (10996, 3490, 'Catalogos', 'Modifico Categoria de precio por nivel creada con el ID :', '2020-05-21 06:10:49');
INSERT INTO `bitacora_movimientos` VALUES (10997, 3490, 'Productos', 'Modificamos el producto con el ID :1000', '2020-05-21 10:35:43');
INSERT INTO `bitacora_movimientos` VALUES (10998, 3490, 'Productos', 'Modificamos el producto con el ID :1000', '2020-05-21 10:37:28');
INSERT INTO `bitacora_movimientos` VALUES (10999, 3490, 'tallas', 'Se elimino el Id :47', '2020-05-21 11:08:32');
INSERT INTO `bitacora_movimientos` VALUES (11000, 3490, 'tallas', 'Se elimino el Id :48', '2020-05-21 11:08:56');
INSERT INTO `bitacora_movimientos` VALUES (11001, 3490, 'tallas', 'Se elimino el Id :49', '2020-05-21 11:09:01');
INSERT INTO `bitacora_movimientos` VALUES (11002, 3490, 'Tallas', 'Modificamos la talla con el ID :39', '2020-05-21 11:53:20');
INSERT INTO `bitacora_movimientos` VALUES (11003, 3490, 'tallas', 'Se elimino el Id :39', '2020-05-21 11:53:27');
INSERT INTO `bitacora_movimientos` VALUES (11004, 3490, 'Tallas', 'Nueva Talla con el ID :54', '2020-05-21 11:53:47');
INSERT INTO `bitacora_movimientos` VALUES (11005, 3490, 'Tallas', 'Modificamos la talla con el ID :54', '2020-05-21 11:54:02');
INSERT INTO `bitacora_movimientos` VALUES (11006, 3490, 'sucursales', 'Modifico Sucursal con ID: -1', '2020-05-22 01:49:40');
INSERT INTO `bitacora_movimientos` VALUES (11007, 3490, 'sucursales', 'Modifico Sucursal con ID: -1', '2020-05-22 01:49:50');
INSERT INTO `bitacora_movimientos` VALUES (11008, 3490, 'entradas', 'Nueva entrada con el ID :519', '2020-05-22 03:58:27');
INSERT INTO `bitacora_movimientos` VALUES (11009, 3490, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :519 IDproducto: 1000', '2020-05-22 03:58:28');
INSERT INTO `bitacora_movimientos` VALUES (11010, 3490, 'entradas', 'Nueva entrada con el ID :520', '2020-05-22 03:59:30');
INSERT INTO `bitacora_movimientos` VALUES (11011, 3490, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :520 IDproducto: 1000', '2020-05-22 03:59:30');
INSERT INTO `bitacora_movimientos` VALUES (11012, 3490, 'entradas', 'Nueva entrada con el ID :521', '2020-05-22 04:08:23');
INSERT INTO `bitacora_movimientos` VALUES (11013, 3490, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :521 IDproducto: 1000', '2020-05-22 04:08:23');
INSERT INTO `bitacora_movimientos` VALUES (11014, 3490, 'entradas', 'Nueva entrada con el ID :522', '2020-05-22 04:12:07');
INSERT INTO `bitacora_movimientos` VALUES (11015, 3490, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :522 IDproducto: 1000', '2020-05-22 04:12:07');
INSERT INTO `bitacora_movimientos` VALUES (11016, 3490, 'entradas', 'Nueva entrada con el ID :523', '2020-05-22 04:19:44');
INSERT INTO `bitacora_movimientos` VALUES (11017, 3490, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :523 IDproducto: 1000', '2020-05-22 04:19:44');
INSERT INTO `bitacora_movimientos` VALUES (11018, 3490, 'entradas', 'Nueva entrada con el ID :524', '2020-05-22 04:26:11');
INSERT INTO `bitacora_movimientos` VALUES (11019, 3490, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :524 IDproducto: 1000', '2020-05-22 04:26:11');
INSERT INTO `bitacora_movimientos` VALUES (11020, 3490, 'entradas', 'Nueva entrada con el ID :525', '2020-05-22 05:14:58');
INSERT INTO `bitacora_movimientos` VALUES (11021, 3490, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :525 IDproducto: 1000', '2020-05-22 05:14:58');
INSERT INTO `bitacora_movimientos` VALUES (11022, 3491, 'perfiles', 'Nuevo Perfil creado -15', '2020-05-22 15:37:10');
INSERT INTO `bitacora_movimientos` VALUES (11023, 3491, 'Administrador', 'Nuevo Usuario creado -amairani', '2020-05-22 15:38:37');
INSERT INTO `bitacora_movimientos` VALUES (11024, 3493, 'entradas', 'Nueva entrada con el ID :526', '2020-05-22 15:51:19');
INSERT INTO `bitacora_movimientos` VALUES (11025, 3493, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :526 IDproducto: 1000', '2020-05-22 15:51:19');
INSERT INTO `bitacora_movimientos` VALUES (11026, 3495, 'entradas', 'Nueva entrada con el ID :527', '2020-06-11 03:42:45');
INSERT INTO `bitacora_movimientos` VALUES (11027, 3495, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :527 IDproducto: 1000', '2020-06-11 03:42:45');
INSERT INTO `bitacora_movimientos` VALUES (11028, 3495, 'entradas', 'Nueva entrada con el ID :528', '2020-06-11 03:45:03');
INSERT INTO `bitacora_movimientos` VALUES (11029, 3495, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :528 IDproducto: 1000', '2020-06-11 03:45:03');
INSERT INTO `bitacora_movimientos` VALUES (11030, 3495, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :528 IDproducto: 1000', '2020-06-11 03:45:03');
INSERT INTO `bitacora_movimientos` VALUES (11031, 3495, 'entradas', 'Nueva entrada con el ID :529', '2020-06-11 03:48:14');
INSERT INTO `bitacora_movimientos` VALUES (11032, 3495, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :529 IDproducto: 1000', '2020-06-11 03:48:14');
INSERT INTO `bitacora_movimientos` VALUES (11033, 3495, 'entradas', 'Nueva entrada con el ID :530', '2020-06-11 03:50:30');
INSERT INTO `bitacora_movimientos` VALUES (11034, 3495, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :530 IDproducto: 1000', '2020-06-11 03:50:30');
INSERT INTO `bitacora_movimientos` VALUES (11035, 3495, 'entradas', 'Nueva entrada con el ID :531', '2020-06-11 03:50:46');
INSERT INTO `bitacora_movimientos` VALUES (11036, 3495, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :531 IDproducto: 1000', '2020-06-11 03:50:46');
INSERT INTO `bitacora_movimientos` VALUES (11037, 3496, 'Productos', 'Modificamos el producto con el ID :1000', '2020-06-11 18:41:55');
INSERT INTO `bitacora_movimientos` VALUES (11038, 3499, 'Salidas', 'Nueva Salida con el ID : 1', '2020-06-11 21:31:51');
INSERT INTO `bitacora_movimientos` VALUES (11039, 3499, 'salidas_detalles', 'Nueva salida de producto con el IDdesalida :1 IDproductos: \"1000|38\"', '2020-06-11 21:31:51');
INSERT INTO `bitacora_movimientos` VALUES (11040, 3499, 'Salidas', 'Nueva Salida con el ID : 2', '2020-06-11 23:02:40');
INSERT INTO `bitacora_movimientos` VALUES (11041, 3499, 'salidas_detalles', 'Nueva salida de producto con el IDdesalida :2 IDproductos: \"1000|38\"', '2020-06-11 23:02:40');
INSERT INTO `bitacora_movimientos` VALUES (11042, 3502, 'entradas', 'Nueva entrada con el ID :532', '2020-07-01 01:01:37');
INSERT INTO `bitacora_movimientos` VALUES (11043, 3502, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :532 IDproducto: 1000', '2020-07-01 01:01:37');
INSERT INTO `bitacora_movimientos` VALUES (11044, 3502, 'entradas', 'Nueva entrada con el ID :533', '2020-07-01 01:09:06');
INSERT INTO `bitacora_movimientos` VALUES (11045, 3502, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :533 IDproducto: 1000', '2020-07-01 01:09:06');
INSERT INTO `bitacora_movimientos` VALUES (11046, 3502, 'entradas', 'Nueva entrada con el ID :534', '2020-07-01 01:13:25');
INSERT INTO `bitacora_movimientos` VALUES (11047, 3502, 'entradas_detalles', 'Nueva entrada de producto con el IDdeentrada :534 IDproducto: 1000', '2020-07-01 01:13:25');
INSERT INTO `bitacora_movimientos` VALUES (11048, 3502, 'Productos', 'Modificamos el producto con el ID :1000', '2020-07-01 01:48:27');
INSERT INTO `bitacora_movimientos` VALUES (11049, 3506, 'compras', 'Nueva compra con el ID :1', '2020-07-02 00:52:28');
INSERT INTO `bitacora_movimientos` VALUES (11050, 3506, 'compras_detalles', 'Nueva compra de producto con el IDcompras :1 IDproducto: 1000', '2020-07-02 00:52:28');
INSERT INTO `bitacora_movimientos` VALUES (11051, 3506, 'compras', 'Nueva compra con el ID :2', '2020-07-02 01:06:10');
INSERT INTO `bitacora_movimientos` VALUES (11052, 3506, 'compras_detalles', 'Nueva compra de producto con el IDcompras :2 IDproducto: 1000', '2020-07-02 01:06:10');
INSERT INTO `bitacora_movimientos` VALUES (11053, 3506, 'compras', 'Se elimino el Id :2', '2020-07-02 01:12:08');
INSERT INTO `bitacora_movimientos` VALUES (11054, 3508, 'Compras', 'Se modifico la compra con el id :1', '2020-07-02 16:39:41');
INSERT INTO `bitacora_movimientos` VALUES (11055, 3508, 'compras', 'Nueva compra con el ID :3', '2020-07-02 22:38:03');
INSERT INTO `bitacora_movimientos` VALUES (11056, 3508, 'compras_detalles', 'Nueva compra de producto con el IDcompras :3 IDproducto: 1000', '2020-07-02 22:38:03');
INSERT INTO `bitacora_movimientos` VALUES (11057, 3508, 'compras', 'Nueva compra con el ID :4', '2020-07-02 22:38:47');
INSERT INTO `bitacora_movimientos` VALUES (11058, 3508, 'compras_detalles', 'Nueva compra de producto con el IDcompras :4 IDproducto: 1000', '2020-07-02 22:38:47');
INSERT INTO `bitacora_movimientos` VALUES (11059, 3508, 'compras', 'Nueva compra con el ID :5', '2020-07-02 22:44:01');
INSERT INTO `bitacora_movimientos` VALUES (11060, 3508, 'compras_detalles', 'Nueva compra de producto con el IDcompras :5 IDproducto: 1000', '2020-07-02 22:44:01');
INSERT INTO `bitacora_movimientos` VALUES (11061, 3511, 'perfiles', 'Modificacion del perfil creado -1', '2020-07-31 17:11:56');
INSERT INTO `bitacora_movimientos` VALUES (11062, 3511, 'perfiles', 'Modificacion del perfil creado -1', '2020-07-31 17:12:19');
INSERT INTO `bitacora_movimientos` VALUES (11063, 3511, 'perfiles', 'Modificacion del perfil creado -1', '2020-07-31 17:12:52');
INSERT INTO `bitacora_movimientos` VALUES (11064, 3511, 'perfiles', 'Modificacion del perfil creado -1', '2020-07-31 17:13:15');
INSERT INTO `bitacora_movimientos` VALUES (11065, 3511, 'perfiles', 'Modificacion del perfil creado -1', '2020-07-31 17:14:16');
INSERT INTO `bitacora_movimientos` VALUES (11066, 3512, 'perfiles', 'Modificacion del perfil creado -1', '2020-07-31 17:24:34');
INSERT INTO `bitacora_movimientos` VALUES (11067, 3512, 'Proveedores', 'Nuevo Proveedor creado con el ID :5', '2020-07-31 17:31:06');
INSERT INTO `bitacora_movimientos` VALUES (11068, 3512, 'proveedores', 'Se elimino el Id :5', '2020-07-31 17:32:26');
INSERT INTO `bitacora_movimientos` VALUES (11069, 3515, 'compras', 'Nueva compra con el ID :6', '2020-11-17 01:12:03');
INSERT INTO `bitacora_movimientos` VALUES (11070, 3515, 'compras_detalles', 'Nueva compra de producto con el IDcompras :6 IDproducto: 1000', '2020-11-17 01:12:03');
INSERT INTO `bitacora_movimientos` VALUES (11071, 3516, 'compras', 'Se elimino el Id :5', '2020-11-17 01:56:30');
INSERT INTO `bitacora_movimientos` VALUES (11072, 3516, 'Compras', 'Se modifico la compra con el id :6', '2020-11-17 01:56:53');
INSERT INTO `bitacora_movimientos` VALUES (11073, 3516, 'perfiles', 'Modificacion del perfil creado -1', '2020-11-17 02:02:06');
INSERT INTO `bitacora_movimientos` VALUES (11074, 3516, 'perfiles', 'Modificacion del perfil creado -1', '2020-11-17 02:02:42');
INSERT INTO `bitacora_movimientos` VALUES (11075, 3516, 'perfiles', 'Modificacion del perfil creado -1', '2020-11-17 02:03:01');
INSERT INTO `bitacora_movimientos` VALUES (11076, 3516, 'perfiles', 'Modificacion del perfil creado -1', '2020-11-17 02:03:47');
INSERT INTO `bitacora_movimientos` VALUES (11077, 3516, 'perfiles', 'Modificacion del perfil creado -1', '2020-11-17 02:04:25');
INSERT INTO `bitacora_movimientos` VALUES (11078, 3516, 'perfiles', 'Modificacion del perfil creado -1', '2020-11-17 02:06:19');
INSERT INTO `bitacora_movimientos` VALUES (11079, 3516, 'perfiles', 'Modificacion del perfil creado -1', '2020-11-17 02:13:15');
INSERT INTO `bitacora_movimientos` VALUES (11080, 3516, 'perfiles', 'Modificacion del perfil creado -1', '2020-11-17 02:17:09');
INSERT INTO `bitacora_movimientos` VALUES (11081, 3518, 'gastos_detalles', 'Se elimino el Id :1', '2020-11-17 10:14:40');
INSERT INTO `bitacora_movimientos` VALUES (11082, 3519, 'Gastos', 'se Modifico el Movimiento del Gasto con el id 2', '2020-11-17 15:42:32');
INSERT INTO `bitacora_movimientos` VALUES (11083, 3519, 'Gastos', 'se Modifico el Movimiento del Gasto con el id 2', '2020-11-17 15:43:05');
INSERT INTO `bitacora_movimientos` VALUES (11084, 3519, 'Gastos', 'se agrego una Ingreso de Gasto con el id 3', '2020-11-17 15:49:47');
INSERT INTO `bitacora_movimientos` VALUES (11085, 3519, 'Gastos', 'se Modifico el Movimiento del Gasto con el id 3', '2020-11-17 15:50:01');
INSERT INTO `bitacora_movimientos` VALUES (11086, 3519, 'gastos_detalles', 'Se elimino el Id :3', '2020-11-17 15:50:14');
INSERT INTO `bitacora_movimientos` VALUES (11087, 3520, 'compras', 'Nueva compra con el ID :9', '2020-11-17 18:40:08');
INSERT INTO `bitacora_movimientos` VALUES (11088, 3520, 'compras_detalles', 'Nueva compra de producto con el IDcompras :9 IDproducto: 1000', '2020-11-17 18:40:08');
INSERT INTO `bitacora_movimientos` VALUES (11089, 3521, 'Compras', 'Se modifico la compra con el id :9', '2020-11-17 19:02:59');

-- ----------------------------
-- Table structure for blog
-- ----------------------------
DROP TABLE IF EXISTS `blog`;
CREATE TABLE `blog`  (
  `idblog` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `imagen` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `estatus` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`idblog`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for categoria_precio
-- ----------------------------
DROP TABLE IF EXISTS `categoria_precio`;
CREATE TABLE `categoria_precio`  (
  `idcategoria_precio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `estatus` int(1) NOT NULL DEFAULT 1 COMMENT '0 - desactivado\n1- activado\n',
  PRIMARY KEY (`idcategoria_precio`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 28 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of categoria_precio
-- ----------------------------
INSERT INTO `categoria_precio` VALUES (7, 'MAYOREO', 1);
INSERT INTO `categoria_precio` VALUES (8, 'MINORISTA', 1);
INSERT INTO `categoria_precio` VALUES (9, 'PÚBLICO', 1);

-- ----------------------------
-- Table structure for categoria_precios_niveles
-- ----------------------------
DROP TABLE IF EXISTS `categoria_precios_niveles`;
CREATE TABLE `categoria_precios_niveles`  (
  `idcategoria_precio` int(11) NOT NULL,
  `idniveles` int(11) NOT NULL,
  `descuento` int(3) NOT NULL DEFAULT 0,
  PRIMARY KEY (`idcategoria_precio`, `idniveles`) USING BTREE,
  INDEX `fk_categoria_precios_niveles_categoria_precio1_idx`(`idcategoria_precio`) USING BTREE,
  INDEX `fk_categoria_precios_niveles_niveles1_idx`(`idniveles`) USING BTREE,
  CONSTRAINT `categoria_precios_niveles_ibfk_1` FOREIGN KEY (`idcategoria_precio`) REFERENCES `categoria_precio` (`idcategoria_precio`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `categoria_precios_niveles_ibfk_2` FOREIGN KEY (`idniveles`) REFERENCES `niveles` (`idniveles`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of categoria_precios_niveles
-- ----------------------------
INSERT INTO `categoria_precios_niveles` VALUES (8, 9, 8);

-- ----------------------------
-- Table structure for categorias
-- ----------------------------
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias`  (
  `idcategoria` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `descripcion` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `estatus` int(1) NULL DEFAULT 1 COMMENT '0-desactivado\n1-activo',
  `nivel` int(11) NOT NULL,
  PRIMARY KEY (`idcategoria`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of categorias
-- ----------------------------
INSERT INTO `categorias` VALUES (22, 'FARMACIA', '', 1, 1);
INSERT INTO `categorias` VALUES (23, 'MOSTRADOR', '', 1, 2);

-- ----------------------------
-- Table structure for clientes
-- ----------------------------
DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes`  (
  `idcliente` int(10) NOT NULL AUTO_INCREMENT,
  `idniveles` int(11) NOT NULL,
  `no_tarjeta` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'SI EL NEGOCIO UTILIZA UN NO. DE TARJETA PARA EL SISTEMA DE LEALTAD\n',
  `nombre` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `paterno` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `materno` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `f_nacimiento` date NULL DEFAULT '1900-12-12',
  `sexo` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'H' COMMENT 'H - HOMBRE\nM - MUJER',
  `direccion` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telefono` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `fax` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `fis_razonsocial` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Razon Social',
  `fis_rfc` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'RFC',
  `fis_direccion` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Direccion Fiscal',
  `fis_no_int` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'No. Interior Fiscal',
  `fis_no_ext` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'No. Exterior Fiscal',
  `fis_col` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Colonia Fiscal',
  `fis_ciudad` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Ciudad Fiscal',
  `fis_estado` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Estado Fiscal',
  `fis_CP` int(11) NULL DEFAULT NULL COMMENT 'Codigo Postal Fiscal',
  `estatus` int(11) NOT NULL,
  `md5_clave` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idcliente`) USING BTREE,
  INDEX `fk_clientes_niveles1_idx`(`idniveles`) USING BTREE,
  CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`idniveles`) REFERENCES `niveles` (`idniveles`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 4136 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of clientes
-- ----------------------------
INSERT INTO `clientes` VALUES (4113, 7, '', 'Jordan', 'Marroquín', 'Velázquez', '2020-02-04', 'H', 'Terán', '123', '123', 'a2dannny.75@gmail.com', '', '', '', '', '', '', '', '', 0, 1, '');
INSERT INTO `clientes` VALUES (4115, 9, '', 'Jorge David', 'Lopez', 'Hernandez', '1900-12-12', 'H', '6 sur entre 3 y 4 oriente', '9614577719', '9614577719', 'jdlhz95@gmail.com', '', '', '', '', '', '', '', '', 0, 1, NULL);
INSERT INTO `clientes` VALUES (4135, 9, NULL, 'MIGUEL', 'ROMERO', 'MEZA', '1995-08-03', 'H', '2 av. Norte #32 entre 5ta. y 7ma. Poniente', '9622156065', '9622156065', 'mikeromero95.geek@gmail.com', '', '', '', '', '', '', '', '', 0, 1, NULL);

-- ----------------------------
-- Table structure for compra_detalle
-- ----------------------------
DROP TABLE IF EXISTS `compra_detalle`;
CREATE TABLE `compra_detalle`  (
  `idcompras` int(11) NOT NULL,
  `idproducto` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `cantidad` int(11) NOT NULL COMMENT 'CANTIDAD DEL PRODUCTO A COMPRAR\n',
  `costo` float(12, 2) NULL DEFAULT 0 COMMENT 'Seria actualización cuando se agregue el detalle de la compra con factura aumentamos el costo del producto.',
  `estatus` int(11) NOT NULL DEFAULT 0 COMMENT '0 - activa\n1 - cancelada\n',
  INDEX `fk_compra_detalle_compras1_idx`(`idcompras`) USING BTREE,
  INDEX `fk_compra_detalle_productos1_idx`(`idproducto`) USING BTREE,
  CONSTRAINT `compra_detalle_ibfk_1` FOREIGN KEY (`idcompras`) REFERENCES `compras` (`idcompras`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `compra_detalle_ibfk_2` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of compra_detalle
-- ----------------------------
INSERT INTO `compra_detalle` VALUES (1, '1000', 1, 0.00, 0);
INSERT INTO `compra_detalle` VALUES (3, '1000', 2, 0.00, 0);
INSERT INTO `compra_detalle` VALUES (4, '1000', 2, 0.00, 0);
INSERT INTO `compra_detalle` VALUES (6, '1000', 19, 0.00, 0);
INSERT INTO `compra_detalle` VALUES (9, '1000', 2, 0.00, 0);

-- ----------------------------
-- Table structure for compras
-- ----------------------------
DROP TABLE IF EXISTS `compras`;
CREATE TABLE `compras`  (
  `idcompras` int(11) NOT NULL AUTO_INCREMENT,
  `idusuarios` int(11) NOT NULL,
  `fecha` timestamp(0) NOT NULL DEFAULT current_timestamp(0) COMMENT 'FECHA EN QUE SE CREA LA ORDEN DE COMPRA',
  `fecha_compra` date NULL DEFAULT NULL COMMENT 'fecha en que realizan la compra\n',
  `prioridad` int(11) NULL DEFAULT NULL COMMENT '0 - normal\n1 - urgente\n2 - alta\n',
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `estatus` int(11) NULL DEFAULT 0 COMMENT '0 - activo\n1 - cancelado\n2 -  comprado\n\n',
  `idsucursales` int(255) NULL DEFAULT NULL,
  PRIMARY KEY (`idcompras`) USING BTREE,
  INDEX `fk_compras_usuarios1_idx`(`idusuarios`) USING BTREE,
  INDEX `sucuralescompras`(`idsucursales`) USING BTREE,
  CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`idusuarios`) REFERENCES `usuarios` (`idusuarios`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sucuralescompras` FOREIGN KEY (`idsucursales`) REFERENCES `sucursales` (`idsucursales`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of compras
-- ----------------------------
INSERT INTO `compras` VALUES (1, 1, '2020-07-02 00:52:28', '2020-07-03', 1, 'asdasdasd', 1, 1);
INSERT INTO `compras` VALUES (3, 1, '2020-07-02 22:38:03', NULL, 0, 'asd', 0, 1);
INSERT INTO `compras` VALUES (4, 1, '2020-07-02 22:38:47', NULL, 0, '', 0, 1);
INSERT INTO `compras` VALUES (6, 1, '2020-11-17 01:12:03', '2020-11-18', 0, 'PRUEBAS', 2, 1);
INSERT INTO `compras` VALUES (9, 1, '2020-11-17 18:40:08', '2020-11-18', 0, 'prueba de ingreso de sucursal', 0, 1);

-- ----------------------------
-- Table structure for compras_detalles_fact
-- ----------------------------
DROP TABLE IF EXISTS `compras_detalles_fact`;
CREATE TABLE `compras_detalles_fact`  (
  `idcompras` int(11) NOT NULL,
  `idproveedores` int(11) NOT NULL,
  `no_factura` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `cantidad` float(12, 2) NULL DEFAULT NULL,
  INDEX `fk_compras_detalles_fact_compras1_idx`(`idcompras`) USING BTREE,
  INDEX `fk_compras_detalles_fact_proveedores1_idx`(`idproveedores`) USING BTREE,
  CONSTRAINT `compras_detalles_fact_ibfk_1` FOREIGN KEY (`idcompras`) REFERENCES `compras` (`idcompras`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `compras_detalles_fact_ibfk_2` FOREIGN KEY (`idproveedores`) REFERENCES `proveedores` (`idproveedores`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for configuracion
-- ----------------------------
DROP TABLE IF EXISTS `configuracion`;
CREATE TABLE `configuracion`  (
  `idconfiguracion` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_empresa` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `direccion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `telefonos` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `email` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `url` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `razon_social` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `rfc` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `direccion_fiscal` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `no_int_fiscal` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `no_ext_fiscal` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `estado_fiscal` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `ciudad_fiscal` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `colonia_fiscal` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `cp_fiscal` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `cuentasbancarias` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `moneda` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `iva` int(11) NOT NULL DEFAULT 0,
  `t_descuento` int(11) NOT NULL DEFAULT 0 COMMENT '0 - por producto.\n1 - por paquete.\n3 - combinado.\n',
  `logo` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT 'logoempresa.png',
  `e_smtp` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL COMMENT 'servidor saliente de email',
  `e_psaliente` int(11) NULL DEFAULT NULL COMMENT 'Puerto Saliente\n',
  `e_pop` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL COMMENT 'servidor entrante de emails',
  `e_pentrante` int(11) NULL DEFAULT NULL COMMENT 'Puerto Entrante\n',
  `e_cuenta` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL COMMENT 'cuenta de email',
  `e_clave` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL COMMENT 'clave del email',
  `e_ss` int(11) NULL DEFAULT 0 COMMENT 'Servidor Seguro?\n\n0 - no\n1 - si\n',
  `e_autentication` int(11) NULL DEFAULT 0 COMMENT '0 - no\n1- si\n',
  `e_verificado` int(11) NULL DEFAULT 0 COMMENT '0 - no\n1 - si',
  `clave_caja` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL COMMENT 'clave de la caja para hacer descuentos directos\n',
  `porc_comision` int(11) NULL DEFAULT 0,
  `notas_print` int(1) NULL DEFAULT 0 COMMENT '0 - CARTA\n1 - TERMICO',
  `email_pedido` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `horario` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `facebook` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `instagram` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `youtube` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `twitter` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idconfiguracion`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of configuracion
-- ----------------------------
INSERT INTO `configuracion` VALUES (1, 'FARMACIA EL SHADDAY', '2DA AV. NORTE NUM 32 ENTRE 5TA Y 7MA PONIENTE, DC. HIDALGO, SUCHIATE, CHIAPAS, MÉXICO', '6980216', 'miguel_romero_cruz@hotmail.com', '', 'FARMACIA SHADDAY', 'ROMM010765', '2DA AV. NORTE NUM 32 ENTRE 5TA Y 7MA PONIENTE', '', '32', 'Chiapas', 'CD HIDALGO', 'CENTRO', '38040', '12345678', 'MNX', 16, 0, 'logo.png', 'undefined', 0, 'undefined', 0, 'undefined', 'undefined', 0, 0, 0, '121275', 0, 0, 'miguel_romero_cruz@hotmail.com', 'Lunes a Domingo de 11:00 am a 08:00 pm', 'https://www.facebook.com/CICmovilCelularesTuxtla/', '', '', '');

-- ----------------------------
-- Table structure for corte
-- ----------------------------
DROP TABLE IF EXISTS `corte`;
CREATE TABLE `corte`  (
  `idcorte` int(11) NOT NULL AUTO_INCREMENT,
  `idusuarios` int(11) NOT NULL,
  `idsucursales` int(11) NOT NULL,
  `f_inicio` date NULL DEFAULT NULL,
  `h_inicio` time(0) NULL DEFAULT NULL,
  `cajachica` float(10, 2) NULL DEFAULT NULL,
  `f_corte` date NULL DEFAULT NULL,
  `h_corte` time(0) NULL DEFAULT NULL,
  `cajacorte` float(10, 2) NULL DEFAULT NULL,
  `cajafinal` float(10, 2) NULL DEFAULT NULL,
  `estatus` int(1) NULL DEFAULT NULL COMMENT '0 - CERRADO\n1 - ACTIVO',
  `efectivo` float(10, 2) NULL DEFAULT NULL,
  `tarjeta` float(10, 2) NULL DEFAULT NULL,
  `trasfer` float(10, 2) NULL DEFAULT NULL,
  `virtual` float(10, 2) NULL DEFAULT NULL,
  `cheque` float(10, 2) NULL DEFAULT NULL,
  `deposito` float(10, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`idcorte`) USING BTREE,
  INDEX `fk_corte_usuarios1_idx`(`idusuarios`) USING BTREE,
  INDEX `fk_corte_sucursales1_idx`(`idsucursales`) USING BTREE,
  CONSTRAINT `corte_ibfk_1` FOREIGN KEY (`idsucursales`) REFERENCES `sucursales` (`idsucursales`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `corte_ibfk_2` FOREIGN KEY (`idusuarios`) REFERENCES `usuarios` (`idusuarios`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for cotizacion
-- ----------------------------
DROP TABLE IF EXISTS `cotizacion`;
CREATE TABLE `cotizacion`  (
  `idcotizacion` int(11) NOT NULL AUTO_INCREMENT,
  `idsucursales` int(11) NOT NULL,
  `idcliente` int(10) NOT NULL,
  `idniveles` int(11) NOT NULL,
  `idusuarios` int(11) NOT NULL,
  `fecha` timestamp(0) NULL DEFAULT current_timestamp(0),
  `iva` float(10, 2) NULL DEFAULT NULL,
  `total` float(10, 2) NULL DEFAULT NULL,
  `estatus` int(11) NULL DEFAULT NULL COMMENT '0 - desactivado\n1 - activo',
  `descuento` float(10, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`idcotizacion`) USING BTREE,
  INDEX `fk_cotizacion_sucursales1_idx`(`idsucursales`) USING BTREE,
  INDEX `fk_cotizacion_usuarios1_idx`(`idusuarios`) USING BTREE,
  CONSTRAINT `cotizacion_ibfk_1` FOREIGN KEY (`idsucursales`) REFERENCES `sucursales` (`idsucursales`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `cotizacion_ibfk_2` FOREIGN KEY (`idusuarios`) REFERENCES `usuarios` (`idusuarios`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for detalle_cotizacion
-- ----------------------------
DROP TABLE IF EXISTS `detalle_cotizacion`;
CREATE TABLE `detalle_cotizacion`  (
  `idcotizacion` int(11) NOT NULL,
  `idproducto` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `cantidad` int(11) NOT NULL COMMENT '	',
  `costo` float(12, 2) NOT NULL,
  `subtotal` float(12, 2) NOT NULL,
  `descuento_porc` int(11) NOT NULL,
  `descuento` float(10, 2) NOT NULL DEFAULT 0,
  `total` float(12, 2) NOT NULL,
  INDEX `fk_table1_cotizacion1_idx`(`idcotizacion`) USING BTREE,
  INDEX `fk_detalle_cotizacion_productos1_idx`(`idproducto`) USING BTREE,
  CONSTRAINT `detalle_cotizacion_ibfk_1` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `detalle_cotizacion_ibfk_2` FOREIGN KEY (`idcotizacion`) REFERENCES `cotizacion` (`idcotizacion`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for entradas
-- ----------------------------
DROP TABLE IF EXISTS `entradas`;
CREATE TABLE `entradas`  (
  `identradas` int(11) NOT NULL AUTO_INCREMENT,
  `idsucursales` int(11) NOT NULL,
  `tipoentrada` int(11) NULL DEFAULT NULL COMMENT '0 - POR COMPRA\n1 - POR DEVOLUCION\n2 - OTROS\n',
  `idusuarios` int(11) NOT NULL,
  `idcompras` int(11) NULL DEFAULT NULL COMMENT 'Si el tipo es compra, se coloca el id de la compra\n',
  `idnota_remision` int(11) NULL DEFAULT NULL COMMENT 'si el motivo es por cambio o devolución, es importante colocar el id de la nota de remisión\n',
  `fecha_entrada` timestamp(0) NOT NULL DEFAULT current_timestamp(0) COMMENT 'fecha de la nota de remisión o factura de la compra',
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  PRIMARY KEY (`identradas`) USING BTREE,
  INDEX `fk_entradas_usuarios1_idx`(`idusuarios`) USING BTREE,
  INDEX `fk_entradas_sucursales1_idx`(`idsucursales`) USING BTREE,
  CONSTRAINT `entradas_ibfk_1` FOREIGN KEY (`idsucursales`) REFERENCES `sucursales` (`idsucursales`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `entradas_ibfk_2` FOREIGN KEY (`idusuarios`) REFERENCES `usuarios` (`idusuarios`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 535 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of entradas
-- ----------------------------
INSERT INTO `entradas` VALUES (494, 1, 0, 1, 0, 0, '2020-02-06 19:15:41', '');
INSERT INTO `entradas` VALUES (496, 1, 0, 1, 0, 0, '2020-02-06 19:18:17', '');
INSERT INTO `entradas` VALUES (499, 1, 0, 1, 0, 0, '2020-02-06 19:21:04', '');
INSERT INTO `entradas` VALUES (500, 1, 0, 1, 0, 0, '2020-02-06 19:21:21', 'asdasdasdasd daasd as dasd asdas da as dasd');
INSERT INTO `entradas` VALUES (501, 1, 2, 1, 0, 0, '2020-02-11 13:09:13', '');
INSERT INTO `entradas` VALUES (502, 1, 0, 1, 0, 0, '2020-02-17 14:18:36', '');
INSERT INTO `entradas` VALUES (503, 1, 0, 1, 0, 0, '2020-02-24 14:33:37', 'PRODUCTO PRUEBA');
INSERT INTO `entradas` VALUES (504, 1, 0, 1, 0, 0, '2020-02-24 18:18:28', '');
INSERT INTO `entradas` VALUES (505, 1, 0, 1, 0, 0, '2020-02-24 18:24:12', '');
INSERT INTO `entradas` VALUES (506, 1, 0, 1, 0, 0, '2020-02-24 18:45:27', '');
INSERT INTO `entradas` VALUES (507, 1, 0, 1, 0, 0, '2020-02-26 12:09:33', '');
INSERT INTO `entradas` VALUES (508, 1, 0, 1, 0, 0, '2020-03-25 13:39:09', '');
INSERT INTO `entradas` VALUES (509, 1, 0, 1, 0, 0, '2020-03-19 11:57:21', '');
INSERT INTO `entradas` VALUES (510, 1, 0, 1, 0, 0, '2020-03-20 13:46:49', '');
INSERT INTO `entradas` VALUES (511, 1, 0, 1, 0, 0, '2020-03-20 13:58:24', '');
INSERT INTO `entradas` VALUES (512, 1, 0, 1, 0, 0, '2020-03-21 12:53:45', '');
INSERT INTO `entradas` VALUES (513, 1, 0, 1, 0, 0, '2020-03-21 17:19:48', '');
INSERT INTO `entradas` VALUES (514, 1, 0, 1, 0, 0, '2020-03-27 23:53:06', '');
INSERT INTO `entradas` VALUES (515, 1, 0, 1, 0, 0, '2020-03-27 23:58:42', '');
INSERT INTO `entradas` VALUES (516, 1, 0, 1, 0, 0, '2020-03-27 00:14:00', '');
INSERT INTO `entradas` VALUES (517, 1, 0, 1, 0, 0, '2020-03-27 16:37:40', '');
INSERT INTO `entradas` VALUES (518, 1, 0, 1, 0, 0, '2020-04-02 14:19:03', '');
INSERT INTO `entradas` VALUES (519, 1, 0, 1, 0, 0, '2020-05-22 03:58:27', '');
INSERT INTO `entradas` VALUES (520, 1, 0, 1, 0, 0, '2020-05-22 03:59:30', '');
INSERT INTO `entradas` VALUES (521, 1, 0, 1, 0, 0, '2020-05-22 04:08:23', '');
INSERT INTO `entradas` VALUES (522, 1, 0, 1, 0, 0, '2020-05-22 04:12:07', '');
INSERT INTO `entradas` VALUES (523, 1, 0, 1, 0, 0, '2020-05-22 04:19:44', '');
INSERT INTO `entradas` VALUES (524, 1, 0, 1, 0, 0, '2020-05-22 04:26:11', '');
INSERT INTO `entradas` VALUES (525, 1, 0, 1, 0, 0, '2020-05-22 05:14:57', '');
INSERT INTO `entradas` VALUES (526, 1, 0, 1, 0, 0, '2020-05-22 15:51:19', 'prubea de ingreso d eproductos');
INSERT INTO `entradas` VALUES (527, 1, 0, 1, 0, 0, '2020-06-11 03:42:45', '');
INSERT INTO `entradas` VALUES (528, 1, 0, 1, 0, 0, '2020-06-11 03:45:03', '');
INSERT INTO `entradas` VALUES (529, 1, 0, 1, 0, 0, '2020-06-11 03:48:14', '');
INSERT INTO `entradas` VALUES (530, 1, 0, 1, 0, 0, '2020-06-11 03:50:30', '');
INSERT INTO `entradas` VALUES (531, 1, 0, 1, 0, 0, '2020-06-11 03:50:46', '');
INSERT INTO `entradas` VALUES (532, 1, 0, 1, 0, 0, '2020-07-08 01:01:37', '');
INSERT INTO `entradas` VALUES (533, 1, 0, 1, 0, 0, '2020-07-16 01:09:06', '');
INSERT INTO `entradas` VALUES (534, 1, 0, 1, 0, 0, '2020-07-01 01:13:25', '');

-- ----------------------------
-- Table structure for entradas_detalles
-- ----------------------------
DROP TABLE IF EXISTS `entradas_detalles`;
CREATE TABLE `entradas_detalles`  (
  `identradas` int(11) NOT NULL,
  `idproducto` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `cantidad` int(11) NOT NULL,
  `idtallas` int(11) NOT NULL,
  INDEX `fk_entradas_detalles_entradas1_idx`(`identradas`) USING BTREE,
  INDEX `fk_entradas_detalles_productos1_idx`(`idproducto`) USING BTREE,
  INDEX `fk_entradas_detalles_tallas1_idx`(`idtallas`) USING BTREE,
  CONSTRAINT `entradas_detalles_ibfk_1` FOREIGN KEY (`identradas`) REFERENCES `entradas` (`identradas`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `entradas_detalles_ibfk_2` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `entradas_detalles_ibfk_3` FOREIGN KEY (`idtallas`) REFERENCES `tallas` (`idtallas`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of entradas_detalles
-- ----------------------------
INSERT INTO `entradas_detalles` VALUES (500, '1000', 5, 42);
INSERT INTO `entradas_detalles` VALUES (519, '1000', 5, 54);
INSERT INTO `entradas_detalles` VALUES (520, '1000', 5, 38);
INSERT INTO `entradas_detalles` VALUES (521, '1000', 5, 54);
INSERT INTO `entradas_detalles` VALUES (522, '1000', 5, 38);
INSERT INTO `entradas_detalles` VALUES (523, '1000', 5, 38);
INSERT INTO `entradas_detalles` VALUES (524, '1000', 5, 38);
INSERT INTO `entradas_detalles` VALUES (525, '1000', 5, 38);
INSERT INTO `entradas_detalles` VALUES (526, '1000', 5, 38);
INSERT INTO `entradas_detalles` VALUES (527, '1000', 2, 38);
INSERT INTO `entradas_detalles` VALUES (528, '1000', 2, 38);
INSERT INTO `entradas_detalles` VALUES (528, '1000', 1, 54);
INSERT INTO `entradas_detalles` VALUES (529, '1000', 2, 38);
INSERT INTO `entradas_detalles` VALUES (530, '1000', 1, 38);
INSERT INTO `entradas_detalles` VALUES (531, '1000', 1, 38);
INSERT INTO `entradas_detalles` VALUES (532, '1000', 2, 54);
INSERT INTO `entradas_detalles` VALUES (533, '1000', 2, 54);
INSERT INTO `entradas_detalles` VALUES (534, '1000', 2, 54);

-- ----------------------------
-- Table structure for etiqueta_detalle
-- ----------------------------
DROP TABLE IF EXISTS `etiqueta_detalle`;
CREATE TABLE `etiqueta_detalle`  (
  `idetiquetas` int(11) NOT NULL,
  `idproducto` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idtallas` int(11) NULL DEFAULT NULL,
  INDEX `fk_table1_etiquetas1_idx`(`idetiquetas`) USING BTREE,
  INDEX `fk_table1_productos1_idx`(`idproducto`) USING BTREE,
  INDEX `valorunidad`(`idtallas`) USING BTREE,
  CONSTRAINT `etiqueta_detalle_ibfk_1` FOREIGN KEY (`idetiquetas`) REFERENCES `etiquetas` (`idetiquetas`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `etiqueta_detalle_ibfk_2` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `etiqueta_detalle_ibfk_3` FOREIGN KEY (`idtallas`) REFERENCES `tallas` (`idtallas`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for etiquetas
-- ----------------------------
DROP TABLE IF EXISTS `etiquetas`;
CREATE TABLE `etiquetas`  (
  `idetiquetas` int(11) NOT NULL AUTO_INCREMENT,
  `idusuarios` int(11) NOT NULL,
  `fecha` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `descripcion` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idetiquetas`) USING BTREE,
  INDEX `fk_etiquetas_usuarios1_idx`(`idusuarios`) USING BTREE,
  CONSTRAINT `etiquetas_ibfk_1` FOREIGN KEY (`idusuarios`) REFERENCES `usuarios` (`idusuarios`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of etiquetas
-- ----------------------------
INSERT INTO `etiquetas` VALUES (3, 1, '2020-02-06 19:25:36', 'Ropa caballero');
INSERT INTO `etiquetas` VALUES (4, 1, '2020-02-06 19:25:44', 'Calzado');
INSERT INTO `etiquetas` VALUES (5, 1, '2020-02-06 19:28:13', 'vestidos');
INSERT INTO `etiquetas` VALUES (9, 1, '2020-03-21 12:59:23', 'HUAWEI ');
INSERT INTO `etiquetas` VALUES (10, 1, '2020-03-27 16:46:29', 'SILICON IPH 6, 6S NGR');

-- ----------------------------
-- Table structure for gastos_categorias
-- ----------------------------
DROP TABLE IF EXISTS `gastos_categorias`;
CREATE TABLE `gastos_categorias`  (
  `idgastos_categorias` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `tipo` int(11) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1 COMMENT '0 - desactivado\n1 - activado\n',
  PRIMARY KEY (`idgastos_categorias`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of gastos_categorias
-- ----------------------------
INSERT INTO `gastos_categorias` VALUES (4, 'pago de luz', 'pago a CFE', 1, 1);

-- ----------------------------
-- Table structure for gastos_detalles
-- ----------------------------
DROP TABLE IF EXISTS `gastos_detalles`;
CREATE TABLE `gastos_detalles`  (
  `idgastos_detalles` int(11) NOT NULL AUTO_INCREMENT,
  `idgastos_categorias` int(11) NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `fecha` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `monto` float(12, 2) NOT NULL DEFAULT 0,
  `estatus` int(11) NOT NULL DEFAULT 0 COMMENT '0 - pendiente\n1 - pagado\n2 - cancelado\n',
  PRIMARY KEY (`idgastos_detalles`) USING BTREE,
  INDEX `fk_gastos_detalles_gastos_categorias1_idx`(`idgastos_categorias`) USING BTREE,
  CONSTRAINT `gastos_detalles_ibfk_1` FOREIGN KEY (`idgastos_categorias`) REFERENCES `gastos_categorias` (`idgastos_categorias`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of gastos_detalles
-- ----------------------------
INSERT INTO `gastos_detalles` VALUES (2, 4, 'asdasdasd', '2020-11-17 00:00:00', 123123.00, 1);

-- ----------------------------
-- Table structure for guias
-- ----------------------------
DROP TABLE IF EXISTS `guias`;
CREATE TABLE `guias`  (
  `idguias` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `fecha` timestamp(0) NULL DEFAULT current_timestamp(0),
  `idnota_remision` int(11) NOT NULL,
  `idpaqueterias` int(11) NOT NULL,
  `fecha_envio` date NULL DEFAULT NULL,
  `comentario` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `estatus` int(1) NULL DEFAULT 1 COMMENT '0 - pendiente\n1 - activado\n2 - cancelado\n',
  PRIMARY KEY (`idguias`) USING BTREE,
  INDEX `fk_guias_paqueterias1_idx`(`idpaqueterias`) USING BTREE,
  INDEX `fk_guias_nota_remision1_idx`(`idnota_remision`) USING BTREE,
  CONSTRAINT `guias_ibfk_1` FOREIGN KEY (`idnota_remision`) REFERENCES `nota_remision` (`idnota_remision`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `guias_ibfk_2` FOREIGN KEY (`idpaqueterias`) REFERENCES `paqueterias` (`idpaqueterias`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of guias
-- ----------------------------
INSERT INTO `guias` VALUES ('12121212', '2020-02-24 19:03:42', 2829, 5, '2020-02-24', 'envio de guia prueba', 1);
INSERT INTO `guias` VALUES ('123456789', '2020-02-06 19:33:47', 2815, 5, '2020-02-07', 'envio express', 1);
INSERT INTO `guias` VALUES ('1234567890', '2020-02-11 11:59:18', 2819, 5, '2020-02-11', 'enviando prueba de guías', 1);

-- ----------------------------
-- Table structure for inventario
-- ----------------------------
DROP TABLE IF EXISTS `inventario`;
CREATE TABLE `inventario`  (
  `idproducto` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idtallas` int(11) NOT NULL,
  `idsucursales` int(11) NOT NULL,
  `existencia` int(11) NOT NULL DEFAULT 0,
  INDEX `fk_inventario_productos1_idx`(`idproducto`) USING BTREE,
  INDEX `fk_inventario_sucursales1_idx`(`idsucursales`) USING BTREE,
  INDEX `fk_inventario_tallas1_idx`(`idtallas`) USING BTREE,
  CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `inventario_ibfk_2` FOREIGN KEY (`idsucursales`) REFERENCES `sucursales` (`idsucursales`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `inventario_ibfk_3` FOREIGN KEY (`idtallas`) REFERENCES `tallas` (`idtallas`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of inventario
-- ----------------------------
INSERT INTO `inventario` VALUES ('1000', 54, 1, 17);
INSERT INTO `inventario` VALUES ('1000', 38, 1, 36);

-- ----------------------------
-- Table structure for lealtad
-- ----------------------------
DROP TABLE IF EXISTS `lealtad`;
CREATE TABLE `lealtad`  (
  `idlealtad` int(11) NOT NULL AUTO_INCREMENT,
  `idcliente` int(10) NOT NULL,
  `idnota_remision` int(11) NOT NULL,
  PRIMARY KEY (`idlealtad`) USING BTREE,
  INDEX `fk_lealtad_clientes1_idx`(`idcliente`) USING BTREE,
  INDEX `fk_lealtad_nota_remision1_idx`(`idnota_remision`) USING BTREE,
  CONSTRAINT `lealtad_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `lealtad_ibfk_2` FOREIGN KEY (`idnota_remision`) REFERENCES `nota_remision` (`idnota_remision`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for modulos
-- ----------------------------
DROP TABLE IF EXISTS `modulos`;
CREATE TABLE `modulos`  (
  `idmodulos` int(11) NOT NULL AUTO_INCREMENT,
  `modulo` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nivel` int(1) NOT NULL DEFAULT 0,
  `estatus` int(1) NULL DEFAULT 1 COMMENT '0 - No activo\n1 - Activo',
  `icono` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idmodulos`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of modulos
-- ----------------------------
INSERT INTO `modulos` VALUES (1, 'ADMINISTRADOR', 1, 1, 'fas fa-users-cog');
INSERT INTO `modulos` VALUES (2, 'CATÁLOGOS', 2, 1, 'fas fa-list');
INSERT INTO `modulos` VALUES (3, 'PRODUCTOS', 3, 1, 'fas fa-cube');
INSERT INTO `modulos` VALUES (4, 'VENTAS', 4, 1, 'fas fa-dollar-sign');
INSERT INTO `modulos` VALUES (5, 'REPOR. Y ESTADIS.', 5, 1, 'fas fa-chart-bar');
INSERT INTO `modulos` VALUES (6, 'PÁGINA WEB', 7, 1, 'fas fa-laptop');
INSERT INTO `modulos` VALUES (7, 'COMPRAS Y GASTOS', 3, 1, 'fas fa-chart-pie');
INSERT INTO `modulos` VALUES (9, 'Mensajes', 8, 1, 'far fa-comments');

-- ----------------------------
-- Table structure for modulos_menu
-- ----------------------------
DROP TABLE IF EXISTS `modulos_menu`;
CREATE TABLE `modulos_menu`  (
  `idmodulos_menu` int(11) NOT NULL AUTO_INCREMENT,
  `idmodulos` int(11) NOT NULL,
  `menu` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `archivo` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ubicacion_archivo` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nivel` int(1) NOT NULL DEFAULT 0,
  `estatus` int(1) NULL DEFAULT 1 COMMENT '0 - No activo\n1 - Activo',
  `icono` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idmodulos_menu`) USING BTREE,
  INDEX `fk_submenus_menus1`(`idmodulos`) USING BTREE,
  CONSTRAINT `modulos_menu_ibfk_1` FOREIGN KEY (`idmodulos`) REFERENCES `modulos` (`idmodulos`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 66 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of modulos_menu
-- ----------------------------
INSERT INTO `modulos_menu` VALUES (1, 1, 'Perfiles', 'vi_perfiles.php', 'administrador/perfiles/', 1, 1, 'fas fa-user');
INSERT INTO `modulos_menu` VALUES (2, 1, 'Usuarios', 'vi_usuarios.php', 'administrador/usuarios/', 2, 1, 'fas fa-users');
INSERT INTO `modulos_menu` VALUES (3, 1, 'Configuración', 'vi_configuracion.php', 'administrador/configuracion/', 3, 1, 'fas fa-cogs');
INSERT INTO `modulos_menu` VALUES (4, 1, 'Sucursales', 'vi_sucursales.php', 'administrador/sucursales/', 4, 1, 'fas fa-store');
INSERT INTO `modulos_menu` VALUES (5, 1, 'Módulos', 'vi_modulos.php', 'administrador/modulos/', 5, 1, 'fas fa-th-list');
INSERT INTO `modulos_menu` VALUES (6, 2, 'Nivel', 'vi_categorias_precios.php', 'catalogos/nivel/', 1, 1, 'fas fa-layer-group');
INSERT INTO `modulos_menu` VALUES (7, 2, 'Proveedores', 'vi_proveedores.php', 'catalogos/proveedores/', 2, 1, 'far fa-address-card');
INSERT INTO `modulos_menu` VALUES (8, 2, 'Servicios', 'vi_servicios.php', 'catalogos/servicios/', 3, 1, 'fas fa-briefcase-medical');
INSERT INTO `modulos_menu` VALUES (9, 2, 'Pacientes', 'vi_pacientes.php', 'catalogos/pacientes/', 4, 1, 'fas fa-id-card-alt');
INSERT INTO `modulos_menu` VALUES (10, 2, 'Cat. de Gastos', 'vi_gastos.php', 'catalogos/gastos/', 6, 1, 'fas fa-money-check-alt');
INSERT INTO `modulos_menu` VALUES (11, 2, 'Paqueterías', 'vi_paqueteria.php', 'catalogos/paqueterias/', 7, 1, 'fas fa-shipping-fast');
INSERT INTO `modulos_menu` VALUES (12, 3, 'Categorías', 'vi_categorias.php', 'productos/categorias/', 1, 1, 'fas fa-layer-group');
INSERT INTO `modulos_menu` VALUES (13, 3, 'Productos', 'vi_productos.php', 'productos/productos/', 3, 1, 'fas fa-pills');
INSERT INTO `modulos_menu` VALUES (14, 3, 'Presentación', 'vi_presentacion.php', 'productos/presentacion/', 2, 1, 'fas fa-diagnoses');
INSERT INTO `modulos_menu` VALUES (15, 3, 'Entradas', 'vi_entradas.php', 'productos/entradas/', 3, 1, 'far fa-caret-square-right');
INSERT INTO `modulos_menu` VALUES (16, 3, 'Salidas', 'vi_salidas.php', 'productos/salidas/', 4, 1, 'far fa-caret-square-left');
INSERT INTO `modulos_menu` VALUES (17, 3, 'Inventario', 'vi_inventario.php', 'productos/inventario/', 5, 1, 'fas fa-capsules');
INSERT INTO `modulos_menu` VALUES (18, 7, 'Compras', 'vi_compras.php', 'compras/compras/', 1, 1, 'fas fa-cart-arrow-down');
INSERT INTO `modulos_menu` VALUES (19, 7, 'Gastos', 'vi_ingreso_gastos.php', 'compras/gastos/', 2, 1, 'fas fa-file-invoice-dollar');
INSERT INTO `modulos_menu` VALUES (20, 4, 'Productos vendidos', 'vi_prod_vend.php', 'ventas/', 8, 1, 'fas fa-tablets');
INSERT INTO `modulos_menu` VALUES (21, 4, 'Pedidos', 'vi_pedidos.php', 'ventas/', 1, 1, 'far fa-bookmark');
INSERT INTO `modulos_menu` VALUES (22, 5, 'Ventas', 'vi_ventas.php', 'reportes/', 1, 1, NULL);
INSERT INTO `modulos_menu` VALUES (23, 6, 'Banner Principal', 'vi_banners.php', 'paginaweb/', 1, 1, NULL);
INSERT INTO `modulos_menu` VALUES (28, 4, 'Generar Pedido', 'fa_ventas.php', 'ventas/', 1, 1, 'fas fa-shopping-cart');
INSERT INTO `modulos_menu` VALUES (33, 4, 'Caja', 'vi_caja.php', 'ventas/', 5, 1, 'fas fa-cash-register');
INSERT INTO `modulos_menu` VALUES (35, 4, 'Pedidos Pagados', 'vi_pedidosPagados.php', 'ventas/', 7, 1, 'fas fa-receipt');
INSERT INTO `modulos_menu` VALUES (38, 5, 'Gastos - Ventas', 'vi_gastosventas.php', 'reportes/', 0, 1, NULL);
INSERT INTO `modulos_menu` VALUES (40, 4, 'Punto de Venta', 'vi_puntodeventa.php', 'ventas/', 0, 1, 'fas fa-hand-holding-usd');
INSERT INTO `modulos_menu` VALUES (42, 4, 'Devoluciones', 'vi_devolucion.php', 'ventas/', 8, 1, 'fas fa-reply-all');
INSERT INTO `modulos_menu` VALUES (50, 4, 'Ventas Clientes', 'vi_venta_cliente.php', 'ventas/', 9, 1, 'fas fa-file-invoice');
INSERT INTO `modulos_menu` VALUES (51, 5, 'Ventas Diarias', 'vi_ventas_dia.php', 'reportes/', 0, 1, NULL);
INSERT INTO `modulos_menu` VALUES (52, 6, 'Blog', 'vi_blog.php', 'blog/', 0, 1, NULL);
INSERT INTO `modulos_menu` VALUES (58, 4, 'Entregas', 'vi_entregas.php', 'ventas/', 2, 1, 'fas fa-shipping-fast');
INSERT INTO `modulos_menu` VALUES (59, 9, 'Mensajes', 'vi_mensajes.php', 'mensajes/', 1, 1, NULL);
INSERT INTO `modulos_menu` VALUES (60, 4, 'Guías', 'vi_guias_pedido.php', 'ventas/', 5, 1, 'far fa-share-square');
INSERT INTO `modulos_menu` VALUES (61, 4, 'Guías', 'vi_guias.php', 'ventas/', 2, 1, 'far fa-share-square');

-- ----------------------------
-- Table structure for niveles
-- ----------------------------
DROP TABLE IF EXISTS `niveles`;
CREATE TABLE `niveles`  (
  `idniveles` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `estatus` int(1) NULL DEFAULT 1 COMMENT '0 - desactivado\n1 - activado\n',
  PRIMARY KEY (`idniveles`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of niveles
-- ----------------------------
INSERT INTO `niveles` VALUES (7, 'ORO', 1);
INSERT INTO `niveles` VALUES (8, 'PLATA', 1);
INSERT INTO `niveles` VALUES (9, 'BRONCE', 1);

-- ----------------------------
-- Table structure for nota_descripcion
-- ----------------------------
DROP TABLE IF EXISTS `nota_descripcion`;
CREATE TABLE `nota_descripcion`  (
  `idnota_remision` int(11) NOT NULL,
  `idproducto` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idtallas` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `costo` float(12, 2) NOT NULL,
  `subtotal` float(12, 2) NOT NULL,
  `descuento_porc` int(11) NULL DEFAULT NULL COMMENT 'la sumatoria del porcentaje de descuento por producto y nivel\n',
  `descuento` float(10, 2) NOT NULL DEFAULT 0 COMMENT 'monto de descuento de ese producto\n\nla multiplicación de pv. por cantidad por descu.\n',
  `total` float(12, 2) NOT NULL COMMENT 'es la diferencia entre subtotal y el descuento.\n\n\n\n',
  `estatus` int(11) NULL DEFAULT 0 COMMENT '0 - vendido\n1- devuelto',
  `dev_derecho` int(11) NULL DEFAULT 0 COMMENT '0 - SI TIENE DERECHO A DEVOLVER\n\n1 - NO TIENE DERECHO A DEVOLVER',
  `nombre_categoria` varchar(90) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  INDEX `fk_nota_descripcion_nota_remision1_idx`(`idnota_remision`) USING BTREE,
  INDEX `fk_nota_descripcion_tallas1_idx`(`idtallas`) USING BTREE,
  INDEX `fk_nota_descripcion_productos1_idx`(`idproducto`) USING BTREE,
  CONSTRAINT `nota_descripcion_ibfk_1` FOREIGN KEY (`idnota_remision`) REFERENCES `nota_remision` (`idnota_remision`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nota_descripcion_ibfk_2` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nota_descripcion_ibfk_3` FOREIGN KEY (`idtallas`) REFERENCES `tallas` (`idtallas`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for nota_entrega
-- ----------------------------
DROP TABLE IF EXISTS `nota_entrega`;
CREATE TABLE `nota_entrega`  (
  `idnota_entrega` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_entrega` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `idnota_remision` int(11) NOT NULL,
  `idusuarios` int(11) NOT NULL,
  PRIMARY KEY (`idnota_entrega`) USING BTREE,
  INDEX `fk_nota_entrega_nota_remision1_idx`(`idnota_remision`) USING BTREE,
  INDEX `fk_nota_entrega_usuarios1_idx`(`idusuarios`) USING BTREE,
  CONSTRAINT `nota_entrega_ibfk_1` FOREIGN KEY (`idnota_remision`) REFERENCES `nota_remision` (`idnota_remision`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nota_entrega_ibfk_2` FOREIGN KEY (`idusuarios`) REFERENCES `usuarios` (`idusuarios`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for nota_entrega_detalle
-- ----------------------------
DROP TABLE IF EXISTS `nota_entrega_detalle`;
CREATE TABLE `nota_entrega_detalle`  (
  `idnota_entrega` int(11) NOT NULL,
  `idproducto` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `cantidad` int(11) NULL DEFAULT NULL,
  INDEX `fk_nota_entrega_detalle_nota_entrega1_idx`(`idnota_entrega`) USING BTREE,
  INDEX `fk_nota_entrega_detalle_productos1_idx`(`idproducto`) USING BTREE,
  CONSTRAINT `nota_entrega_detalle_ibfk_1` FOREIGN KEY (`idnota_entrega`) REFERENCES `nota_entrega` (`idnota_entrega`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nota_entrega_detalle_ibfk_2` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for nota_remision
-- ----------------------------
DROP TABLE IF EXISTS `nota_remision`;
CREATE TABLE `nota_remision`  (
  `idnota_remision` int(11) NOT NULL AUTO_INCREMENT,
  `idsucursales` int(11) NOT NULL,
  `idcliente` int(10) NOT NULL DEFAULT 0 COMMENT '1 - VENTA DIRECTA.\n\nCUALQUIER ID SI ES GENERADA POR UN CLIENTE EN ESPECIFICO DESDE EL WEB O DE UN CLIENTE EN LA BASE DE DATOS.\n',
  `idniveles` int(11) NOT NULL,
  `idusuarios` int(11) NOT NULL DEFAULT 0 COMMENT '0 - GENERADO DESDE EL SITIO WEB O CIENTE.\n\nCUALQUIER OTRO IDE DE USUARIO SI ES GENERADO EN VENTANILLA\n',
  `fechapedido` timestamp(0) NOT NULL DEFAULT current_timestamp(0) COMMENT 'Fecha cuando realizamos el pedido.',
  `fecha_pago` timestamp(0) NULL DEFAULT NULL COMMENT 'fecha cuando realizamos el pago.\nde la nota de remisión o crédito\n',
  `tipo_pago` int(11) NOT NULL DEFAULT 0 COMMENT '0 - Efectivo\n1 - tarjeta de credito\n2 - tarjeta de debito\n3 - cheque\n4 - deposito\n5 - transferencia\n6 - credito\n\n',
  `referencia` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '0' COMMENT '0 - no existe ninguna referencia fue contado.',
  `no_seguridad` varchar(34) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'no. de seguridad obtenido por el encriptado en php MD5 de \nno. de pedido,no de cliente, fecha y hora minutos segundos para enviarlo a paypal o cualquier otro método de cobro en linea.\n\nesto hacer que mi pedido sea único en su cadena.',
  `tipo_descuento` int(11) NOT NULL DEFAULT 0 COMMENT '0 - por producto\n1 - por paquete\n2 - por ambos\n3 - Directo\n',
  `facturado` int(11) NOT NULL DEFAULT 0 COMMENT '0 - no\n1 -si\n',
  `no_factura` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT 'XAXX010101000',
  `corte` int(1) NOT NULL DEFAULT 0 COMMENT 'este campo nos indica si la venta sigue activa para el corte.\n\n0 - activo para corte\n1 - ya en corte\n',
  `subtotal` float(12, 2) NOT NULL DEFAULT 0,
  `desc_producto` float(12, 2) NULL DEFAULT 0 COMMENT 'descuento aplicado directamente en el producto.',
  `desc_paquetes` float(12, 2) NULL DEFAULT 0 COMMENT 'descuento que se aplica dese un catalogo de un minimo a máximo de compra y genera un descuento\n',
  `porc_desc_directo` int(10) NULL DEFAULT 0 COMMENT 'Porcentaje que se aplica a la nota en descuento directo sobre la nota de remisión.',
  `desc_directo` float(12, 2) NULL DEFAULT 0 COMMENT 'descuento aplicado directamente desde caja.',
  `iva` float(12, 2) NOT NULL DEFAULT 0,
  `total` float(12, 2) NOT NULL DEFAULT 0,
  `estatus` int(11) NULL DEFAULT 0 COMMENT '0 - pendiente de pago   \n1 - pagado  //si se paga en caja o se termina de pagar un crédito.\n2 - cancelado\n3 - Crédito\n4.- Crédito Pagado\n\n',
  `tipo_tc` int(1) NULL DEFAULT NULL COMMENT 'tipo de tarjeta de credito o debito\n\n0 - credito\n1 - debito.',
  `4digi_tc` int(4) NULL DEFAULT NULL,
  `monto_tc` float(12, 2) NULL DEFAULT NULL,
  `refer_tc` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL COMMENT 'no. de movimiento que se cobro con la tarjeta.',
  `monto_cheque` float(12, 2) NULL DEFAULT NULL COMMENT '			',
  `refer_cheque` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `monto_deposito` float(10, 2) NULL DEFAULT NULL,
  `refer_deposito` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `no_deposito` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `banco_deposito` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `monto_transfer` float(10, 2) NULL DEFAULT NULL,
  `refer_transfer` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `no_transfer` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `banco_transfer` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `monto_efec` float(10, 2) NULL DEFAULT NULL,
  `cambio` float(10, 2) NULL DEFAULT NULL,
  `monto_virtual` float(10, 2) NULL DEFAULT 0 COMMENT 'PAGO CON DINERO VIRTUAL, SE TOMA DE LA TABLA CLIENTE MONEDERO.\n',
  `idcliente_monedero` int(11) NOT NULL DEFAULT 0 COMMENT 'en esta area ingresamos el idcliente_monedero para hacer referencia al movimiento en cliente_monedero.\n\nsiempre y cuando pague con monedero virtual.\n\n',
  `autorizado` int(1) NOT NULL DEFAULT 0,
  `tipo_envio` int(1) NULL DEFAULT 1 COMMENT '0 - RECOGER EN TIENDA\n1 - ENVIO A DIRECCION',
  `direccion_envio` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `comentario` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  PRIMARY KEY (`idnota_remision`) USING BTREE,
  INDEX `fk_nota_remision_sucursales1_idx`(`idsucursales`) USING BTREE,
  CONSTRAINT `nota_remision_ibfk_1` FOREIGN KEY (`idsucursales`) REFERENCES `sucursales` (`idsucursales`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 2870 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of nota_remision
-- ----------------------------
INSERT INTO `nota_remision` VALUES (2815, 1, 4115, 9, 1, '2020-02-06 19:31:13', '2020-02-06 19:32:30', 0, '0', '4149f651751af32c0e1e1c328ea8b33b', 0, 0, 'XAXX010101000', 0, 3515.06, 203.94, 0.00, 0, 0.00, 0.00, 3515.06, 1, 0, 0, 0.00, '', 0.00, '', 0.00, '', '', '', 0.00, '', '', '', 3516.00, 0.94, 0.00, 0, 0, 1, NULL, 'se pago en una sola exhibición');
INSERT INTO `nota_remision` VALUES (2816, 1, 4113, 7, 1, '2020-02-10 15:21:35', NULL, 0, '0', '0ee54679093fc3ce3390e5715217ce55', 0, 0, 'XAXX010101000', 0, 1800.00, 0.00, 0.00, 0, 0.00, 1.00, 1800.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2817, 1, 4113, 7, 1, '2020-02-10 17:35:20', NULL, 0, '0', '061a5db96dc49ece3e4c19282381cc5b', 0, 0, 'XAXX010101000', 0, 252.00, 0.00, 0.00, 0, 0.00, 34.76, 252.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2818, 1, 4113, 7, 1, '2020-02-10 18:47:19', NULL, 0, '0', '93b798d7e60c89850a301df70579f54d', 0, 0, 'XAXX010101000', 0, 5602.00, 0.00, 0.00, 0, 0.00, 5.00, 5602.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2819, 1, 4113, 7, 1, '2020-02-11 11:46:53', '2020-02-11 12:12:22', 0, '0', 'a28e3e8e9a80b6bf85d3b13dc1e98f89', 0, 0, 'XAXX010101000', 0, 2449.00, 0.00, 0.00, 0, 0.00, 0.00, 2449.00, 1, 0, 0, 0.00, '', 0.00, '', 0.00, '', '', '', 0.00, '', '', '', 2449.00, 0.00, 0.00, 0, 1, 0, '', 'probando pago de pedidos en caja');
INSERT INTO `nota_remision` VALUES (2820, 1, 4113, 7, 1, '2020-02-17 16:29:36', NULL, 0, '0', '0cf92485b8789e043d45289a060829af', 0, 0, 'XAXX010101000', 0, 64.66, 0.00, 0.00, 0, 0.00, 10.34, 75.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 1, NULL, NULL);
INSERT INTO `nota_remision` VALUES (2822, 1, 4113, 7, 1, '2020-02-24 09:54:46', NULL, 0, '0', '744920e90de4f257f2b018bede9cf161', 0, 0, 'XAXX010101000', 0, 1800.00, 0.00, 0.00, 0, 0.00, 1.00, 1800.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2823, 1, 4113, 7, 1, '2020-02-24 10:04:33', NULL, 0, '0', 'e4337d2a9de403b4e52272d300ad7635', 0, 0, 'XAXX010101000', 0, 200.00, 0.00, 0.00, 0, 0.00, 27.59, 200.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2824, 1, 4113, 7, 1, '2020-02-24 10:08:44', NULL, 0, '0', 'e9b2ae4083fae1344b7013f3b09c3d05', 0, 0, 'XAXX010101000', 0, 252.00, 0.00, 0.00, 0, 0.00, 34.76, 252.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2825, 1, 4113, 7, 1, '2020-02-24 10:18:26', NULL, 0, '0', '7a2226037d212c39377744bf56ddfe57', 0, 0, 'XAXX010101000', 0, 2000.00, 0.00, 0.00, 0, 0.00, 1.00, 2000.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2826, 1, 4113, 7, 1, '2020-02-24 10:26:11', NULL, 0, '0', '22240d2ad008c3cfcce8b2e07d36bf23', 0, 0, 'XAXX010101000', 0, 4099.00, 0.00, 0.00, 0, 0.00, 4.00, 4099.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2827, 1, 4113, 7, 1, '2020-02-24 10:42:10', NULL, 0, '0', 'a0fee15936dac71352e11a118c7a166f', 0, 0, 'XAXX010101000', 0, 1123.00, 0.00, 0.00, 0, 0.00, 154.90, 1123.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2828, 1, 4113, 7, 1, '2020-02-24 10:43:40', NULL, 0, '0', '3ad1a67ccdf73960da1479ea161290cd', 0, 0, 'XAXX010101000', 0, 200.00, 0.00, 0.00, 0, 0.00, 27.59, 200.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2829, 1, 4124, 9, 1, '2020-02-24 14:41:56', '2020-02-24 14:48:33', 0, '0', '013f9f7e590323be738b5ae0b16272aa', 0, 0, 'XAXX010101000', 0, 1574.00, 0.00, 0.00, 0, 0.00, 0.00, 1574.00, 1, 0, 0, 0.00, '', 0.00, '', 0.00, '', '', '', 0.00, '', '', '', 1574.00, 0.00, 0.00, 0, 1, 0, '', '');
INSERT INTO `nota_remision` VALUES (2830, 1, 4126, 9, 1, '2020-02-25 15:54:19', NULL, 0, '0', '1789e7c898196d7115f7069e18d2991d', 0, 0, 'XAXX010101000', 0, 145730.00, 0.00, 0.00, 0, 0.00, 145.00, 145730.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2831, 1, 4126, 9, 1, '2020-02-25 15:59:48', NULL, 0, '0', '2ada91aa8d2fd00a91a1c65c5cc1515d', 0, 0, 'XAXX010101000', 0, 145655.00, 0.00, 0.00, 0, 0.00, 145.00, 145655.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2832, 1, 4126, 9, 1, '2020-02-25 16:01:28', NULL, 0, '0', 'cbe58d4a101ff5689e4cf907e657c6a4', 0, 0, 'XAXX010101000', 0, 75.00, 0.00, 0.00, 0, 0.00, 10.34, 75.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2833, 1, 4129, 9, 1, '2020-02-26 12:00:04', NULL, 0, '0', '7c18c01cb10351138cad6b7df1b1b2c1', 0, 0, 'XAXX010101000', 0, 150.00, 0.00, 0.00, 0, 0.00, 20.69, 150.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2834, 1, 4129, 9, 1, '2020-02-26 12:04:27', NULL, 0, '0', '6429303573fe0b0619544d2cccfb96f8', 0, 0, 'XAXX010101000', 0, 145580.00, 0.00, 0.00, 0, 0.00, 145.00, 145580.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2835, 1, 4129, 9, 1, '2020-02-26 12:09:57', NULL, 0, '0', 'a66522e25feead9adcf85d71c44edf71', 0, 0, 'XAXX010101000', 0, 145730.00, 0.00, 0.00, 0, 0.00, 145.00, 145730.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2836, 1, 4129, 9, 1, '2020-02-26 12:11:45', NULL, 0, '0', 'd9aaad1a785dc1c811a8a4f7ad4ce9d0', 0, 0, 'XAXX010101000', 0, 291310.00, 0.00, 0.00, 0, 0.00, 291.00, 291310.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2837, 1, 4129, 9, 1, '2020-02-26 12:16:29', NULL, 0, '0', '4e80d6acec5a4fac7805aa598564ffe7', 0, 0, 'XAXX010101000', 0, 145580.00, 0.00, 0.00, 0, 0.00, 145.00, 145580.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2838, 1, 4129, 9, 1, '2020-02-26 12:19:22', NULL, 0, '0', '4366e5d2d3ac7f59072e2043515af8f2', 0, 0, 'XAXX010101000', 0, 145730.00, 0.00, 0.00, 0, 0.00, 145.00, 145730.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2839, 1, 4124, 9, 1, '2020-02-26 16:16:02', NULL, 0, '0', '28a0f87b357b75fe39da613e43344b14', 0, 0, 'XAXX010101000', 0, 582620.00, 0.00, 0.00, 0, 0.00, 582.00, 582620.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2840, 1, 4128, 9, 1, '2020-02-29 21:48:17', NULL, 0, '0', '5f019ef1cce37a3a1884dd464ec2558e', 0, 0, 'XAXX010101000', 0, 75.00, 0.00, 0.00, 0, 0.00, 10.34, 75.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2841, 1, 4128, 9, 1, '2020-02-29 22:45:23', NULL, 0, '0', 'ec7c3114f95615915583743d2ddbcadf', 0, 0, 'XAXX010101000', 0, 1580.00, 0.00, 0.00, 0, 0.00, 1.00, 1580.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2842, 1, 4128, 9, 1, '2020-03-04 13:15:30', NULL, 0, '0', '91dd44c37c8b1e93184e9db9afa6d062', 0, 0, 'XAXX010101000', 0, 3310.00, 0.00, 0.00, 0, 0.00, 3.00, 3310.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2843, 1, 4128, 9, 1, '2020-03-19 17:17:32', NULL, 0, '0', 'a985f21e1b3093d726f85b8b21af94e1', 0, 0, 'XAXX010101000', 0, 1655.00, 0.00, 0.00, 0, 0.00, 1.00, 1655.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2844, 1, 4128, 9, 1, '2020-03-19 17:22:03', NULL, 0, '0', '221b63296b4380787c27a943ae934708', 0, 0, 'XAXX010101000', 0, 6320.00, 0.00, 0.00, 0, 0.00, 6.00, 6320.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2845, 1, 4128, 9, 1, '2020-03-19 17:23:34', NULL, 0, '0', '1667bb58f274acd32fc8a44cf028ae24', 0, 0, 'XAXX010101000', 0, 3160.00, 0.00, 0.00, 0, 0.00, 3.00, 3160.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2846, 1, 4128, 9, 1, '2020-03-19 17:25:42', NULL, 0, '0', '00f201963a58fbee57b784a5dccccbbd', 0, 0, 'XAXX010101000', 0, 1580.00, 0.00, 0.00, 0, 0.00, 1.00, 1580.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2847, 1, 4128, 9, 1, '2020-03-20 22:39:57', '2020-03-21 13:13:58', 0, '0', '4cb8f02e1bd4724a1f6664f2e906ed65', 0, 0, 'XAXX010101000', 0, 1580.00, 0.00, 0.00, 0, 0.00, 0.00, 1580.00, 1, 0, 0, 0.00, '', 0.00, '', 0.00, '', '', '', 0.00, '', '', '', 1580.00, 0.00, 0.00, 0, 0, 0, '', '');
INSERT INTO `nota_remision` VALUES (2848, 1, 4128, 9, 1, '2020-03-20 22:52:32', NULL, 0, '0', 'f90c2c01e2616760e9e236173a581b37', 0, 0, 'XAXX010101000', 0, 275.00, 0.00, 0.00, 0, 0.00, 37.93, 275.00, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2849, 1, 0, 0, 1, '2020-03-21 13:11:49', '2020-03-21 13:12:48', 0, '0', 'e7f07cb8b067d94dc3bbb7fae9196b40', 0, 0, 'XAXX010101000', 0, 6894.82, 0.00, 0.00, 0, 0.00, 0.00, 6894.82, 1, 0, 0, 0.00, '', 0.00, '', 0.00, '', '', '', 0.00, '', '', '', 6894.82, 0.00, 0.00, 0, 0, 1, NULL, 'debemos una mica pasaa recoger martes');
INSERT INTO `nota_remision` VALUES (2850, 1, 4133, 9, 1, '2020-03-21 14:34:56', NULL, 0, '0', '30c903a4038adcb1225cd0b5e7b9fd56', 0, 0, 'XAXX010101000', 0, 20.00, 0.00, 0.00, 0, 0.00, 2.76, 20.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 1, '5A NORTE PONIENTE 213-A COL. CENTRO CP 29000 ENTRE 1A Y 2A PONIENTE ', NULL);
INSERT INTO `nota_remision` VALUES (2851, 1, 4133, 9, 1, '2020-03-23 17:31:23', '2020-03-23 17:32:31', 0, '0', 'b81f8a1b3a83d7bd8cb4b97e69341959', 0, 0, 'XAXX010101000', 0, 3999.00, 0.00, 0.00, 0, 0.00, 0.00, 3999.00, 1, 1, 1234, 39990.00, '1234', 0.00, '', 0.00, '', '', '', 0.00, '', '', '', 0.00, 35991.00, 0.00, 0, 0, 1, NULL, '');
INSERT INTO `nota_remision` VALUES (2852, 1, 4133, 9, 1, '2020-03-26 18:27:11', NULL, 0, '0', 'b32a9796447a35a4238503ba937a7f52', 0, 0, 'XAXX010101000', 0, 3999.00, 0.00, 0.00, 0, 0.00, 3.00, 3999.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 1, '5A NORTE PONIENTE 213-A COL. CENTRO CP 29000 ENTRE 1A Y 2A PONIENTE ', NULL);
INSERT INTO `nota_remision` VALUES (2853, 1, 4134, 9, 1, '2020-04-11 14:15:53', NULL, 0, '0', 'd4113ddacf22f6f29df994792e636347', 0, 0, 'XAXX010101000', 0, 250.00, 0.00, 0.00, 0, 0.00, 34.48, 250.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2854, 1, 4129, 9, 1, '2020-04-14 01:44:00', NULL, 0, '0', '82d9e12fc4decf7e51884435f62e76b1', 0, 0, 'XAXX010101000', 0, 3349.00, 0.00, 0.00, 0, 0.00, 3.00, 3349.00, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2855, 1, 4129, 9, 1, '2020-04-14 01:46:04', NULL, 0, '0', '3a2897388a83f16104fe010469674c69', 0, 0, 'XAXX010101000', 0, 3349.00, 0.00, 0.00, 0, 0.00, 3.00, 3349.00, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2856, 1, 4129, 9, 1, '2020-04-14 02:15:19', NULL, 0, '0', '1c808cf0c64297beac08250395039f33', 0, 0, 'XAXX010101000', 0, 2799.00, 0.00, 0.00, 0, 0.00, 2.00, 2799.00, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2857, 1, 4129, 9, 1, '2020-04-15 13:42:41', NULL, 0, '0', '729ebc3edc8cf2e072fed698052c4f48', 0, 0, 'XAXX010101000', 0, 1299.00, 0.00, 0.00, 0, 0.00, 1.00, 1299.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 0, '', NULL);
INSERT INTO `nota_remision` VALUES (2858, 1, 4133, 9, 1, '2020-04-20 17:58:52', NULL, 0, '0', '7d51c3a9859f382fe04799455698e7ac', 0, 0, 'XAXX010101000', 0, 250.00, 0.00, 0.00, 0, 0.00, 34.48, 250.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 1, '5A NORTE PONIENTE 213-A COL. CENTRO CP 29000 ENTRE 1A Y 2A PONIENTE ', NULL);
INSERT INTO `nota_remision` VALUES (2859, 1, 0, 0, 1, '2020-04-24 00:34:35', NULL, 0, '0', '6fbcb0b3afd016fdd2c507c25cd019f9', 0, 0, 'XAXX010101000', 0, 1.00, 0.00, 0.00, 0, 0.00, 1.00, 1469.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 0, 1, NULL, NULL);
INSERT INTO `nota_remision` VALUES (2869, 1, 4114, 8, 1, '2020-04-25 02:23:51', '2020-04-25 02:24:43', 0, '0', '3258df91e77b67514964d7fe38e60d6a', 0, 0, 'XAXX010101000', 0, 3447.41, 0.00, 0.00, 0, 0.00, 551.59, 3999.00, 1, 1, 12, 3999.00, '424242XXXXXX4242', 0.00, '', 0.00, '', '', '', 0.00, '', '', '', 0.00, 0.00, 3999.00, 2, 0, 0, '', '');

-- ----------------------------
-- Table structure for nota_remision_depositos
-- ----------------------------
DROP TABLE IF EXISTS `nota_remision_depositos`;
CREATE TABLE `nota_remision_depositos`  (
  `idnota_remision_depositos` int(11) NOT NULL AUTO_INCREMENT,
  `idnota_remision` int(11) NOT NULL,
  `fecha` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `fecha_deposito` datetime(0) NOT NULL,
  `referencia` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `banco` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `monto` float(10, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`idnota_remision_depositos`) USING BTREE,
  INDEX `fk_nota_remision_depositos_nota_remision2_idx`(`idnota_remision`) USING BTREE,
  CONSTRAINT `nota_remision_depositos_ibfk_1` FOREIGN KEY (`idnota_remision`) REFERENCES `nota_remision` (`idnota_remision`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1269 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of nota_remision_depositos
-- ----------------------------
INSERT INTO `nota_remision_depositos` VALUES (1261, 2819, '2020-02-11 11:50:06', '2020-02-11 11:50:00', NULL, 'Bancoppel', 3000.00);
INSERT INTO `nota_remision_depositos` VALUES (1263, 2819, '2020-02-11 11:55:03', '2020-02-11 12:00:00', '12345', 'Bancoppel', 2777.00);
INSERT INTO `nota_remision_depositos` VALUES (1264, 2820, '2020-02-18 11:06:50', '2020-02-18 02:04:00', '', 'HSBC', 2000.00);
INSERT INTO `nota_remision_depositos` VALUES (1265, 2820, '2020-02-18 11:08:04', '2020-02-18 09:09:00', '', 'Banamex', 200.00);
INSERT INTO `nota_remision_depositos` VALUES (1266, 2820, '2020-02-18 11:11:02', '2020-02-18 10:11:00', '1234567890', 'HSBC', 20.00);
INSERT INTO `nota_remision_depositos` VALUES (1267, 2829, '2020-02-24 14:44:59', '2020-02-24 14:23:00', '1235ht', 'Santander', 1800.00);
INSERT INTO `nota_remision_depositos` VALUES (1268, 2839, '2020-02-26 16:17:11', '2020-02-26 05:00:00', '23456', 'Bancoppel', 2343566.00);

-- ----------------------------
-- Table structure for nota_remision_imgdepositos
-- ----------------------------
DROP TABLE IF EXISTS `nota_remision_imgdepositos`;
CREATE TABLE `nota_remision_imgdepositos`  (
  `idnota_remision_imgdepositos` int(11) NOT NULL AUTO_INCREMENT,
  `idnota_remision` int(11) NOT NULL,
  `imagen` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `fecha` timestamp(0) NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`idnota_remision_imgdepositos`) USING BTREE,
  INDEX `fk_nota_remision_depositos_nota_remision1_idx`(`idnota_remision`) USING BTREE,
  CONSTRAINT `nota_remision_imgdepositos_ibfk_1` FOREIGN KEY (`idnota_remision`) REFERENCES `nota_remision` (`idnota_remision`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1240 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of nota_remision_imgdepositos
-- ----------------------------
INSERT INTO `nota_remision_imgdepositos` VALUES (1231, 2819, NULL, '2020-02-11 11:50:06');
INSERT INTO `nota_remision_imgdepositos` VALUES (1232, 2819, '2819-1232.jpg', '2020-02-11 11:51:40');
INSERT INTO `nota_remision_imgdepositos` VALUES (1235, 2820, '2820-1235.jpg', '2020-02-18 11:06:50');
INSERT INTO `nota_remision_imgdepositos` VALUES (1236, 2820, '2820-1236.jpg', '2020-02-18 11:08:04');
INSERT INTO `nota_remision_imgdepositos` VALUES (1237, 2820, '2820-1237.jpg', '2020-02-18 11:11:02');
INSERT INTO `nota_remision_imgdepositos` VALUES (1238, 2829, '2829-1238.jpg', '2020-02-24 14:44:59');
INSERT INTO `nota_remision_imgdepositos` VALUES (1239, 2839, '2839-1239.jpg', '2020-02-26 16:17:11');

-- ----------------------------
-- Table structure for pagos
-- ----------------------------
DROP TABLE IF EXISTS `pagos`;
CREATE TABLE `pagos`  (
  `idpagos` int(11) NOT NULL AUTO_INCREMENT,
  `id` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `authorization` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `operation_type` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `method` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `transaction_type` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `card_type` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `card_brand` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `card_card_number` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `card_expiration_year` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `card_expiration_month` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `card_allows_charges` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `card_allows_payouts` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `card_bank_name` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `card_bank_code` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `creation_date` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `operation_date` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `description` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `order_id` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `currency` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `amount` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idpagos`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of pagos
-- ----------------------------
INSERT INTO `pagos` VALUES (1, 'trpelcdwb7ojinnayrgz', '801585', 'in', 'card', 'charge', 'debit', 'visa', '411111XXXXXX1111', '25', '12', '1', '1', 'Banamex', '002', 'completed', '2020-04-24T17:24:04-05:00', '2020-04-24T17:24:05-05:00', 'probando', '0000002821', 'MXN', '200');
INSERT INTO `pagos` VALUES (2, 'trc1v6xfkiwdwhq9s0o1', '801585', 'in', 'card', 'charge', 'credit', 'visa', '424242XXXXXX4242', '25', '12', '1', '', 'BANCOMER', '012', 'completed', '2020-04-24T17:58:07-05:00', '2020-04-24T17:58:08-05:00', 'probando', '0000002860', 'MXN', '5198');
INSERT INTO `pagos` VALUES (3, 'tryjeelxeaijesi3bxle', '801585', 'in', 'card', 'charge', 'credit', 'visa', '424242XXXXXX4242', '23', '12', '1', '', 'BANCOMER', '012', 'completed', '2020-04-24T18:15:46-05:00', '2020-04-24T18:15:47-05:00', 'probando', '0000002861', 'MXN', '6638');
INSERT INTO `pagos` VALUES (4, 'trc4p1fwybyv47ofeo4o', '801585', 'in', 'card', 'charge', 'credit', 'visa', '424242XXXXXX4242', '25', '12', '1', '', 'BANCOMER', '012', 'completed', '2020-04-24T18:30:01-05:00', '2020-04-24T18:30:03-05:00', 'probando', '0000002862', 'MXN', '1679');
INSERT INTO `pagos` VALUES (5, 'truzvgkplb5pwyueh8yi', '801585', 'in', 'card', 'charge', 'credit', 'visa', '424242XXXXXX4242', '26', '05', '1', '', 'BANCOMER', '012', 'completed', '2020-04-24T22:51:58-05:00', '2020-04-24T22:52:00-05:00', 'probando', '0000002863', 'MXN', '2699');
INSERT INTO `pagos` VALUES (6, 'trevd8nmebvclhp8tp5m', '801585', 'in', 'card', 'charge', 'credit', 'visa', '424242XXXXXX4242', '24', '12', '1', '', 'BANCOMER', '012', 'completed', '2020-04-24T23:34:11-05:00', '2020-04-24T23:34:12-05:00', 'probando', '0000002866', 'MXN', '399');
INSERT INTO `pagos` VALUES (7, 'trfvoxagxyig9slunct4', '801585', 'in', 'card', 'charge', 'credit', 'visa', '424242XXXXXX4242', '24', '12', '1', '', 'BANCOMER', '012', 'completed', '2020-04-24T23:41:01-05:00', '2020-04-24T23:41:01-05:00', 'probando', '0000002867', 'MXN', '2699');
INSERT INTO `pagos` VALUES (8, 'tr9iaw2r09dtjjnezosc', '801585', 'in', 'card', 'charge', 'credit', 'visa', '424242XXXXXX4242', '21', '12', '1', '', 'BANCOMER', '012', 'completed', '2020-04-25T02:06:11-05:00', '2020-04-25T02:06:11-05:00', 'probando', '0000002868', 'MXN', '2799');
INSERT INTO `pagos` VALUES (9, 'trmwbny8arf4ndsuyec6', '801585', 'in', 'card', 'charge', 'credit', 'visa', '424242XXXXXX4242', '24', '12', '1', '', 'BANCOMER', '012', 'completed', '2020-04-25T02:24:36-05:00', '2020-04-25T02:24:37-05:00', 'probando', '0000002869', 'MXN', '3999');
INSERT INTO `pagos` VALUES (10, 'tryjcikelqjrdvcoxiq6', '801585', 'in', 'card', 'charge', 'credit', 'visa', '424242XXXXXX4242', '25', '12', '1', '', 'BANCOMER', '012', 'completed', '2020-04-25T03:02:14-05:00', '2020-04-25T03:02:15-05:00', 'probando', '0000002870', 'MXN', '2699');

-- ----------------------------
-- Table structure for paqueterias
-- ----------------------------
DROP TABLE IF EXISTS `paqueterias`;
CREATE TABLE `paqueterias`  (
  `idpaqueterias` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `direccion` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `email` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tel` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `estatus` int(1) NULL DEFAULT 1 COMMENT '0 - desactivado\n1 - activado.\n',
  `urlrastreo` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idpaqueterias`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of paqueterias
-- ----------------------------
INSERT INTO `paqueterias` VALUES (4, 'Estafeta', ' Sexta Poniente Norte Núm. 618, Tuxtla Gutierrez, CS 29000 MX ', 'fedex@fedex.com', '9611214676', 1, 'https://www.fedex.com/es-mx/home.html');
INSERT INTO `paqueterias` VALUES (5, 'DHL', 'Av. Central Ote. 1033, Centro, 29000 Tuxtla Gutiérrez, Chis.', 'INFO@DHL.COM.MX', '5553457000', 1, 'https://www.logistics.dhl/mx-es/home/rastreo.html');

-- ----------------------------
-- Table structure for perfiles
-- ----------------------------
DROP TABLE IF EXISTS `perfiles`;
CREATE TABLE `perfiles`  (
  `idperfiles` int(11) NOT NULL AUTO_INCREMENT,
  `perfil` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `estatus` int(1) NULL DEFAULT 1 COMMENT '0 - No activo\n1 - Activo',
  PRIMARY KEY (`idperfiles`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of perfiles
-- ----------------------------
INSERT INTO `perfiles` VALUES (1, 'Administrador', 1);
INSERT INTO `perfiles` VALUES (15, 'prueba', 1);

-- ----------------------------
-- Table structure for perfiles_permisos
-- ----------------------------
DROP TABLE IF EXISTS `perfiles_permisos`;
CREATE TABLE `perfiles_permisos`  (
  `idperfiles` int(11) NOT NULL,
  `idmodulos_menu` int(11) NOT NULL,
  `insertar` int(11) NULL DEFAULT 0,
  `borrar` int(11) NULL DEFAULT 0,
  `modificar` int(11) NULL DEFAULT 0,
  INDEX `fk_perfiles_has_modulos_menu_modulos_menu1`(`idmodulos_menu`) USING BTREE,
  INDEX `fk_perfiles_has_modulos_menu_perfiles1`(`idperfiles`) USING BTREE,
  CONSTRAINT `perfiles_permisos_ibfk_1` FOREIGN KEY (`idmodulos_menu`) REFERENCES `modulos_menu` (`idmodulos_menu`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `perfiles_permisos_ibfk_2` FOREIGN KEY (`idperfiles`) REFERENCES `perfiles` (`idperfiles`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of perfiles_permisos
-- ----------------------------
INSERT INTO `perfiles_permisos` VALUES (15, 4, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (15, 6, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (15, 7, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (15, 8, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (15, 9, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (15, 10, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (15, 11, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 1, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 2, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 3, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 4, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 5, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 6, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 7, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 8, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 9, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 10, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 11, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 12, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 13, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 14, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 15, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 16, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 17, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 20, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 21, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 28, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 33, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 35, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 40, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 42, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 50, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 58, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 60, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 61, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 22, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 38, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 51, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 23, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 52, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 18, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 19, 1, 1, 1);
INSERT INTO `perfiles_permisos` VALUES (1, 59, 1, 1, 1);

-- ----------------------------
-- Table structure for preguntas
-- ----------------------------
DROP TABLE IF EXISTS `preguntas`;
CREATE TABLE `preguntas`  (
  `idpreguntas` int(12) NOT NULL AUTO_INCREMENT,
  `pregunta` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `respuesta` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `estatus` int(12) NULL DEFAULT NULL COMMENT '0- desactivado, 1- activado',
  PRIMARY KEY (`idpreguntas`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of preguntas
-- ----------------------------
INSERT INTO `preguntas` VALUES (1, '¿Qué es lorem?', 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. \n\nNo sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. \nFue popularizado en los 60s con la creación de las hojas \"Letraset\", las cuales contenian pasajes de Lorem Ipsum, \ny más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.', 1);
INSERT INTO `preguntas` VALUES (2, '¿elimnar?', 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. \n\nNo sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. \nFue popularizado en los 60s con la creación de las hojas \"Letraset\", las cuales contenian pasajes de Lorem Ipsum, \ny más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.', 1);

-- ----------------------------
-- Table structure for productos
-- ----------------------------
DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos`  (
  `idproducto` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'no acepta caracteres especiales',
  `idcategoria_precio` int(11) NOT NULL DEFAULT 1,
  `cod_proveedor` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL COMMENT 'Contienen el código de su proveedor.',
  `f_creacion` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `pc` float(11, 2) NULL DEFAULT 0 COMMENT 'Precio Costo',
  `pv` float(11, 2) NOT NULL COMMENT 'precio venta ya con iva.\n',
  `descuento` int(11) NOT NULL DEFAULT 0,
  `foto` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `thumb` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `stok_min` int(11) NOT NULL DEFAULT 0,
  `unidad` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT 'PZ' COMMENT 'PZ - PIEZAS\nLT - LITROS\nKG - KILOGRAMOS.',
  `estatus` int(11) NOT NULL DEFAULT 0 COMMENT '0 - no activo\n1 - activo\n',
  `idsobrepedido_camp` int(11) NULL DEFAULT NULL,
  `idsubcategoria` int(15) NOT NULL,
  PRIMARY KEY (`idproducto`) USING BTREE,
  INDEX `fk_productos_categoria_precio1_idx`(`idcategoria_precio`) USING BTREE,
  INDEX `fk_subcategoria1_idx`(`idsubcategoria`) USING BTREE,
  CONSTRAINT `fk_subcategoria1` FOREIGN KEY (`idsubcategoria`) REFERENCES `subcategoria` (`idsubcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`idcategoria_precio`) REFERENCES `categoria_precio` (`idcategoria_precio`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of productos
-- ----------------------------
INSERT INTO `productos` VALUES ('1000', 9, '', '2020-05-21 04:45:17', 'PARACETAMÓL', 'Analgésico usado, para dolores medios, dosis recomendada 1 tableta cada 8 horas', 30.00, 40.00, 35, '1000-Paracetamol_Infantil_125MG_6S_HD.jpg', NULL, 5, 'PZ', 1, NULL, 49);

-- ----------------------------
-- Table structure for proveedores
-- ----------------------------
DROP TABLE IF EXISTS `proveedores`;
CREATE TABLE `proveedores`  (
  `idproveedores` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `telefono` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `email` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `contacto` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `estatus` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL COMMENT '0 - no activo el proveedor\n1 - activo el proveedor\n',
  `url` varchar(80) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idproveedores`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of proveedores
-- ----------------------------
INSERT INTO `proveedores` VALUES (3, 'CAPSE', '7a. Ote. entre 1a. y 2a. Sur #251 Col. Centro', '9626980216', 'info@capse.mx', 'Lic. Concepción Corzo Santiago', NULL, 'www.capse.mx');

-- ----------------------------
-- Table structure for push_mensajes
-- ----------------------------
DROP TABLE IF EXISTS `push_mensajes`;
CREATE TABLE `push_mensajes`  (
  `idpush_mensajes` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `fecha` datetime(0) NOT NULL,
  `de` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `para` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tipo` int(1) NULL DEFAULT NULL COMMENT '0 - mensaje general\n1 - mensaje de sistema\n2 - guias\n3 - mensajes sobre pedido',
  `mensaje` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `estatus` int(1) NULL DEFAULT 0 COMMENT '0 - pendiente\n1 - leido\n2 - borrado',
  PRIMARY KEY (`idpush_mensajes`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of push_mensajes
-- ----------------------------
INSERT INTO `push_mensajes` VALUES (1, 'jdlhz95@gmail.com', '2020-02-06 19:33:47', 'ventas@calzadodayanara.com', 'Jorge David Lopez Hernandez', 2, 'GUIAS- Datos de rastreo.  No. pedido #2815\n\r No. Guía: 123456789 Paquetería: DHL', 0);
INSERT INTO `push_mensajes` VALUES (2, 'a2dany.75@gmail.com', '2020-02-11 11:59:18', 'ventas@calzadodayanara.com', 'Jordan MarroquÃ­n VelÃ¡zquez', 2, 'GUIAS- Datos de rastreo.  No. pedido #2819\n\r No. Guía: 1234567890 Paquetería: DHL', 0);
INSERT INTO `push_mensajes` VALUES (3, 'mikeromero95.geek@gmail.com', '2020-02-17 16:42:58', 'ventas@calzadodayanara.com', 'MIGUEL ROMERO MEZA', 2, 'GUIAS- Datos de rastreo.  No. pedido #2814\n\r No. Guía: 1212121212 Paquetería: DHL', 0);
INSERT INTO `push_mensajes` VALUES (4, 'mikeromero95.geek@gmail.com', '2020-02-17 16:44:19', 'ventas@calzadodayanara.com', 'MIGUEL ROMERO MEZA', 2, 'GUIAS- Datos de rastreo.  No. pedido #2814\n\r No. Guía: 121212121213 Paquetería: Fedex', 0);
INSERT INTO `push_mensajes` VALUES (5, 'consuecommerce@gmail.com', '2020-02-24 19:03:42', 'ventas@calzadodayanara.com', 'Consue Corzo Santiago', 2, 'GUIAS- Datos de rastreo.  No. pedido #2829\n\r No. Guía: 12121212 Paquetería: DHL', 0);

-- ----------------------------
-- Table structure for push_registro
-- ----------------------------
DROP TABLE IF EXISTS `push_registro`;
CREATE TABLE `push_registro`  (
  `idpush_registro` int(11) NOT NULL AUTO_INCREMENT,
  `ids` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `token` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `so` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alias` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `idusuario` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idpush_registro`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for salidas
-- ----------------------------
DROP TABLE IF EXISTS `salidas`;
CREATE TABLE `salidas`  (
  `idsalidas` int(11) NOT NULL AUTO_INCREMENT,
  `idsucursales` int(11) NOT NULL,
  `idusuarios` int(11) NOT NULL,
  `fecha` datetime(0) NOT NULL,
  `tipo` int(11) NOT NULL DEFAULT 0 COMMENT '0 - ventas\n1 - devolución\n2 - producto falla\n3 - caducado\n\n',
  `idnota_remision` int(11) NULL DEFAULT NULL COMMENT 'es el no. de la nota de remisión.\nsi el producto sale por venta\n',
  PRIMARY KEY (`idsalidas`) USING BTREE,
  INDEX `fk_salidas_sucursales1_idx`(`idsucursales`) USING BTREE,
  INDEX `fk_salidas_usuarios1_idx`(`idusuarios`) USING BTREE,
  CONSTRAINT `salidas_ibfk_1` FOREIGN KEY (`idsucursales`) REFERENCES `sucursales` (`idsucursales`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `salidas_ibfk_2` FOREIGN KEY (`idusuarios`) REFERENCES `usuarios` (`idusuarios`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of salidas
-- ----------------------------
INSERT INTO `salidas` VALUES (1, 1, 1, '2020-06-11 00:00:00', 0, 0);
INSERT INTO `salidas` VALUES (2, 1, 1, '2020-06-11 00:00:00', 0, 0);

-- ----------------------------
-- Table structure for salidas_detalles
-- ----------------------------
DROP TABLE IF EXISTS `salidas_detalles`;
CREATE TABLE `salidas_detalles`  (
  `idsalidas` int(11) NOT NULL,
  `idproducto` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` float(12, 2) NOT NULL,
  `descuento` int(11) NOT NULL DEFAULT 0,
  `total` float(12, 2) NOT NULL,
  `idtallas` int(11) NOT NULL,
  INDEX `fk_salidas_detalles_salidas1_idx`(`idsalidas`) USING BTREE,
  INDEX `fk_salidas_detalles_productos1_idx`(`idproducto`) USING BTREE,
  INDEX `fk_salidas_detalles_tallas1_idx`(`idtallas`) USING BTREE,
  CONSTRAINT `salidas_detalles_ibfk_1` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `salidas_detalles_ibfk_2` FOREIGN KEY (`idsalidas`) REFERENCES `salidas` (`idsalidas`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `salidas_detalles_ibfk_3` FOREIGN KEY (`idtallas`) REFERENCES `tallas` (`idtallas`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of salidas_detalles
-- ----------------------------
INSERT INTO `salidas_detalles` VALUES (1, '1000', 1, 0.00, 0, 0.00, 38);
INSERT INTO `salidas_detalles` VALUES (2, '1000', 1, 0.00, 0, 0.00, 38);

-- ----------------------------
-- Table structure for subcategoria
-- ----------------------------
DROP TABLE IF EXISTS `subcategoria`;
CREATE TABLE `subcategoria`  (
  `idsubcategoria` int(15) NOT NULL AUTO_INCREMENT,
  `idcategoria` int(15) NOT NULL,
  `nombre` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `estatus` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`idsubcategoria`) USING BTREE,
  INDEX `categoria`(`idcategoria`) USING BTREE,
  CONSTRAINT `categoria` FOREIGN KEY (`idcategoria`) REFERENCES `categorias` (`idcategoria`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 50 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of subcategoria
-- ----------------------------
INSERT INTO `subcategoria` VALUES (49, 22, 'MEDICAMENTOS', '', '1');

-- ----------------------------
-- Table structure for sucursales
-- ----------------------------
DROP TABLE IF EXISTS `sucursales`;
CREATE TABLE `sucursales`  (
  `idsucursales` int(11) NOT NULL AUTO_INCREMENT,
  `sucursal` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `direccion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `tel` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `tipo` int(1) NULL DEFAULT NULL COMMENT '0 - principal\n1 - sucursales\n',
  `notas_print` int(1) NULL DEFAULT NULL COMMENT '0 - CARTA\n1 - TERMICO',
  `estatus` int(255) NULL DEFAULT NULL COMMENT '0- desactivo, 1 - activo',
  PRIMARY KEY (`idsucursales`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sucursales
-- ----------------------------
INSERT INTO `sucursales` VALUES (1, 'Matriz', '2av. Norte Num 32, Ciudad Hidalgo, Suchiate, Chiapas, México', '9626980216', 'miguel_romero_cruz@hotmail.com', 0, 1, 1);

-- ----------------------------
-- Table structure for tallas
-- ----------------------------
DROP TABLE IF EXISTS `tallas`;
CREATE TABLE `tallas`  (
  `idtallas` int(11) NOT NULL AUTO_INCREMENT,
  `unidad` varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `valor` varchar(90) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `estatus` int(11) NULL DEFAULT NULL,
  `descripcion` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`idtallas`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 55 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tallas
-- ----------------------------
INSERT INTO `tallas` VALUES (38, 'PZ', '', 1, 'Piezas');
INSERT INTO `tallas` VALUES (40, 'TALLA', '23', 1, 'Calzado');
INSERT INTO `tallas` VALUES (41, 'TALLA', '24', 1, 'Calzado');
INSERT INTO `tallas` VALUES (42, 'TALLA', '25', 1, 'Calzado');
INSERT INTO `tallas` VALUES (43, 'TALLA', '26', 1, 'Calzado');
INSERT INTO `tallas` VALUES (44, 'TALLA', '27', 1, 'Calzado');
INSERT INTO `tallas` VALUES (45, 'LT', '1', 1, 'Litro');
INSERT INTO `tallas` VALUES (46, 'LT', '2', 1, 'Litros');
INSERT INTO `tallas` VALUES (50, 'KG', '1', 1, 'Kilogramo');
INSERT INTO `tallas` VALUES (51, 'KG', '2', 1, 'Kilogramos');
INSERT INTO `tallas` VALUES (52, 'MG', '300', 1, 'Gramos');
INSERT INTO `tallas` VALUES (53, 'MG', '500', 1, 'Gramos');
INSERT INTO `tallas` VALUES (54, 'PZ', '333', 1, 'edicion');

-- ----------------------------
-- Table structure for traspaso
-- ----------------------------
DROP TABLE IF EXISTS `traspaso`;
CREATE TABLE `traspaso`  (
  `idtraspaso` int(11) NOT NULL AUTO_INCREMENT,
  `idusuarios` int(11) NOT NULL,
  `fecha` timestamp(0) NULL DEFAULT current_timestamp(0),
  `de` int(11) NULL DEFAULT NULL COMMENT 'ID DE LA SUCURSAL QUE ENVIA',
  `para` int(11) NULL DEFAULT NULL COMMENT 'ID SUCURSAL QUE RECIBE.',
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  PRIMARY KEY (`idtraspaso`) USING BTREE,
  INDEX `fk_traspaso_usuarios1_idx`(`idusuarios`) USING BTREE,
  CONSTRAINT `traspaso_ibfk_1` FOREIGN KEY (`idusuarios`) REFERENCES `usuarios` (`idusuarios`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for traspaso_detalle
-- ----------------------------
DROP TABLE IF EXISTS `traspaso_detalle`;
CREATE TABLE `traspaso_detalle`  (
  `idtraspaso` int(11) NOT NULL,
  `idproducto` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `cantidad` int(11) NOT NULL,
  `idtallas` int(11) NULL DEFAULT NULL,
  INDEX `idtraspaso`(`idtraspaso`) USING BTREE,
  INDEX `idproducto`(`idproducto`) USING BTREE,
  INDEX `idproducto_2`(`idproducto`) USING BTREE,
  INDEX `idproducto_3`(`idproducto`) USING BTREE,
  INDEX `idproducto_4`(`idproducto`) USING BTREE,
  INDEX `idproducto_5`(`idproducto`) USING BTREE,
  CONSTRAINT `traspaso_detalle_ibfk_1` FOREIGN KEY (`idtraspaso`) REFERENCES `traspaso` (`idtraspaso`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios`  (
  `idusuarios` int(11) NOT NULL AUTO_INCREMENT COMMENT '0 - USUARIOS INTERNOS\n1 - USUARIOS EXTERNOS',
  `idperfiles` int(11) NOT NULL,
  `nombre` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `paterno` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `materno` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `telefono` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '----',
  `celular` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '----',
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `usuario` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `clave` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT 1,
  `tipo` int(1) NULL DEFAULT NULL COMMENT '0 - super usuario\n1 - Empresa',
  `tipo_usuario` int(1) NULL DEFAULT 0 COMMENT '0 - USUARIOS INTERNOS\n1 - USUARIOS EXTERNOS',
  `tipo_telefono` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '1' COMMENT '1 - android\n0 - iphone',
  `token` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `idsucursales` int(255) NULL DEFAULT NULL,
  PRIMARY KEY (`idusuarios`) USING BTREE,
  INDEX `fk_usuarios_perfiles1`(`idperfiles`) USING BTREE,
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`idperfiles`) REFERENCES `perfiles` (`idperfiles`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 31 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES (1, 1, 'MIGUEL', 'ROMERO', 'MEZA', '9626980216', '9622156065', 'mikeromero95.geek@gmail.com', 'al02638387', 'ob5KA9WsyW', 1, 0, 1, '1', '12345', 2);
INSERT INTO `usuarios` VALUES (30, 15, 'amairani', 'islas', 'panfila', '', '', 'iamarani631@gmail.com', 'amairani', '1234567', 1, 0, 0, '1', NULL, NULL);

SET FOREIGN_KEY_CHECKS = 1;
