-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Φιλοξενητής: localhost:3306
-- Χρόνος δημιουργίας: 18 Φεβ 2021 στις 17:37:33
-- Έκδοση διακομιστή: 10.3.16-MariaDB
-- Έκδοση PHP: 7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `id15389497_medicalagendadb`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `pattient`
--

CREATE TABLE `pattient` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `town` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `insurance` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amka` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `createdat` datetime DEFAULT NULL,
  `lastvisitat` datetime DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `medicalBio` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `zipcode` int(5) DEFAULT NULL,
  `profession` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `pattient`
--

INSERT INTO `pattient` (`id`, `firstname`, `lastname`, `age`, `gender`, `address`, `town`, `phone`, `insurance`, `amka`, `createdat`, `lastvisitat`, `userid`, `email`, `medicalBio`, `zipcode`, `profession`) VALUES
(69, 'Andreas', 'Andreou', 45, 'Male', 'a', 'a', 'a', 'a', 'a', '2021-01-01 16:40:42', '2021-01-02 16:40:42', 23, 'bb@bb.com', 'a', 35100, ''),
(70, 'Ιωάννης', 'Σκούμπας', 32, 'Male', 'Ξανθου 7', 'Λαμια', '324234234', 'asdfasdfasd', '21341234123', '2021-02-15 10:02:37', '2021-02-15 10:02:58', 32, 'giannis9500@gmail.com', NULL, 35100, NULL),
(71, 'Nikolaos', 'Nikolaou', 67, 'Male', 'Kallitheas 35', 'Athens', '2354235234', 'EOPYY', '32423423452', '2021-02-18 17:02:50', '2021-02-18 17:02:50', 21, 'nick@yahoo.com', NULL, 12345, NULL),
(72, 'Petros', 'Petrou', 24, 'Male', 'Lamias 32', 'Lamia', '3242354234', 'IKA', '34534653463', '2021-02-18 17:02:37', '2021-02-18 17:02:37', 21, 'petros@sdfs.com', NULL, 23543, NULL),
(73, 'Athina', 'Athineou', 42, 'Fmale', 'Larisas 22', 'Larisa', '2342345675', 'TAPYT', '23453252356', '2021-02-18 17:02:47', '2021-02-18 17:02:47', 21, 'athina@gmail.gr', ' ', 32523, ''),
(74, 'Kostas', 'Kostantinou', 88, 'Male', 'Porou 25', 'Poros', '3245235235', 'TSMEDE', '32432523452', '2021-02-18 17:02:53', '2021-02-18 17:02:53', 21, 'ks@efwef.com', NULL, 32421, NULL),
(75, 'Vasiliki', 'Vasileiou', 46, 'Fmale', 'Kozanis 78', 'Kozani', '3464364567', 'EOPYY', '34634646456', '2021-02-18 17:02:42', '2021-02-18 17:02:42', 21, 'yjk@sdfgds.com', NULL, 67867, NULL),
(76, 'Nikos', 'Agathokleous', 18, 'Male', 'Kyrpou 90', 'Athina', '3453465346', 'TAPYT', '43534534634', '2021-02-18 17:02:17', '2021-02-18 17:02:17', 21, 'wwe@s.com', NULL, 32423, NULL);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `createdat` timestamp NULL DEFAULT current_timestamp(),
  `modifiedat` datetime DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `token` text DEFAULT NULL,
  `isactive` tinyint(1) NOT NULL DEFAULT 1,
  `role` varchar(255) NOT NULL,
  `patientId` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Άδειασμα δεδομένων του πίνακα `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `createdat`, `modifiedat`, `firstname`, `lastname`, `token`, `isactive`, `role`, `patientId`, `email`) VALUES
(21, 'doctor', '140c93ccbd7d7a3e8d3a04d4c740d8962231b694f3a02069a0e31ad01564de07b0fe1ff07b4818780d82b0f07b3dd6d503e9a1ca24e6adefb545b500cdbc9b00', '2020-11-16 21:53:06', '2021-02-18 17:22:11', 'Georgios', 'Georgiou', '2d32413eb3242b960a81e14ddbf879fc461e9cebc37f097a662fbdbb4618a2d1e9a5db3145a2cbf106e055e4e087f7af1a3f1724848f0909a5785b6efc73a5f1', 1, 'doctor', NULL, ''),
(22, 'admin', '140c93ccbd7d7a3e8d3a04d4c740d8962231b694f3a02069a0e31ad01564de07b0fe1ff07b4818780d82b0f07b3dd6d503e9a1ca24e6adefb545b500cdbc9b00', '2020-11-16 21:55:45', '2021-02-16 21:12:59', 'admin', 'admin', '963e434b5eec8995b95b96918e7ae9b07f7097d424fe0be18f7206177dc19628ec7e125b90dcab07eaf1433599ec942ee770c50ff994eefa66658be4242b9d40', 1, 'admin', NULL, ''),
(23, 'visitor', '140c93ccbd7d7a3e8d3a04d4c740d8962231b694f3a02069a0e31ad01564de07b0fe1ff07b4818780d82b0f07b3dd6d503e9a1ca24e6adefb545b500cdbc9b00', '2020-11-16 21:55:45', '2021-02-16 21:12:43', 'Andreas', 'Andreou', '356df20cd4c161e1613aa7575375ae8292167f8975a8f600ddd22e94b3fb0955763302a6dd7c39e4df3673dd31e593ca8922b156826b87bf76c68856f3711831', 1, 'visitor', 69, ''),
(32, 'ioanskoulam', '818a4e10931e8606d8deb63525451c34c550b6b2c01d037a5a9352d3d7b59f077b905dbfcb74a8a8fac24bb2e6ec58ef50fab00767ece466fc08a020de5bf67a', '2021-02-15 10:49:15', '2021-02-15 10:52:05', 'Ιωάννης', 'Σκούμπας', '9b6c510837c8206d62ae9d924216523168f77b08ac74f2ebc07d2a59b7854505807f88a246b90f137aad2532e64bee17960e48057f406a2ea3438d30f95f6cc6', 1, 'doctor', NULL, 'giannis9500@gmail.com'),
(33, 'ioanskoulam', '818a4e10931e8606d8deb63525451c34c550b6b2c01d037a5a9352d3d7b59f077b905dbfcb74a8a8fac24bb2e6ec58ef50fab00767ece466fc08a020de5bf67a', '2021-02-15 11:01:27', NULL, 'Ιωάννης', 'Σκούμπας', 'a4f2ac5a33bd81760e547c2eb47163f2d80ee21f0bb0278ced702ca525a436b8d40e2e67c25f7a7e4662946383e977d51e25a1d05a6c931384631d0bd53233a5', 0, 'visitor', 70, 'giannis950123120@gmail.com'),
(34, 'doctor', '140c93ccbd7d7a3e8d3a04d4c740d8962231b694f3a02069a0e31ad01564de07b0fe1ff07b4818780d82b0f07b3dd6d503e9a1ca24e6adefb545b500cdbc9b00', '2021-02-16 19:55:00', NULL, '', '', 'f91232e01672cea067bb566fa673b9cfab51b619d6d97600e8563bde77eac478d57803d7f66ba10a762b6e46e8b80d765ab71bbf3d092773cdc231d152fe7ad6', 0, 'doctor', NULL, 'dd@dd.cpok'),
(35, 's', '140c93ccbd7d7a3e8d3a04d4c740d8962231b694f3a02069a0e31ad01564de07b0fe1ff07b4818780d82b0f07b3dd6d503e9a1ca24e6adefb545b500cdbc9b00', '2021-02-16 19:59:07', NULL, 'a', 'a', '0ee2c763ca2f0d8dd17f375a576e61bdd13f05ac901ded49d9601ec09f880933dd3c3fbfc5a60afbef62bef395d6a09f1458586681540ea440110af24e791f96', 0, 'doctor', NULL, 'm@m.com'),
(36, 'q', '140c93ccbd7d7a3e8d3a04d4c740d8962231b694f3a02069a0e31ad01564de07b0fe1ff07b4818780d82b0f07b3dd6d503e9a1ca24e6adefb545b500cdbc9b00', '2021-02-16 20:28:38', NULL, 'q', 'q', '9c857820fe7193a6a75c5b49eff5ad2cecddd2c3c46c5a23cbac00f7a8e8308885d2d82503d1ebee00405b95a4a4decc5b35b9ee04147ec034a142e7db299322', 0, 'visitor', 34, 'qq@qq.com'),
(37, 'q', '140c93ccbd7d7a3e8d3a04d4c740d8962231b694f3a02069a0e31ad01564de07b0fe1ff07b4818780d82b0f07b3dd6d503e9a1ca24e6adefb545b500cdbc9b00', '2021-02-16 20:29:24', NULL, 'q', 'q', '09fe53f426468048cf843c0eb815a99296733790829b6a1ed634091dc78a2d1e6f87acbfc64b6e98b3ad621d94c8185941c7fc8df967ab7fc9082a882bc8d47b', 0, 'visitor', 346534634, 'gg@dd.com');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `visits`
--

CREATE TABLE `visits` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `patientId` int(11) NOT NULL,
  `visitAt` datetime DEFAULT NULL,
  `systolic` double DEFAULT NULL,
  `diastolic` double DEFAULT NULL,
  `glucose` double DEFAULT NULL,
  `comments` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `pattient`
--
ALTER TABLE `pattient`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `pattient`
--
ALTER TABLE `pattient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT για πίνακα `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT για πίνακα `visits`
--
ALTER TABLE `visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
