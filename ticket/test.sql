-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 01, 2021 at 08:19 AM
-- Server version: 5.7.28-0ubuntu0.18.04.4
-- PHP Version: 7.3.11-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `welove_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `owners`
--

CREATE TABLE `owners` (
  `id` int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `owners`
--

INSERT INTO `owners` (`id`, `name`, `email`) VALUES
(1, 'Test Owner', 'test@test.io');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `title`, `description`) VALUES
(1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'Phasellus porttitor molestie erat. Mauris vulputate at arcu at elementum. Etiam faucibus varius porta. Donec in magna in lorem congue varius vel in elit. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed sit amet diam molestie, elementum mi dapibus, egestas libero. Duis sem lectus, laoreet quis semper nec, mattis eget ex. Integer ac lobortis tortor. Sed at varius ipsum. Cras eget lacus non turpis egestas faucibus. Morbi vel iaculis felis, sed lobortis nunc. Donec placerat magna id quam vestibulum accumsan.'),
(2, 'Pellentesque bibendum vehicula sapien, a molestie velit pharetra nec.', 'Donec eget neque nec eros interdum porta. Quisque quis tempor massa, et pellentesque dolor. Phasellus accumsan velit ut porttitor hendrerit. Donec sodales diam id vehicula aliquam. Praesent ut lorem quis neque aliquet tincidunt et a eros. Pellentesque non vulputate elit. Sed auctor neque id velit porttitor, vitae interdum turpis blandit. Nulla cursus eros accumsan justo aliquet, ut egestas diam mollis. Sed gravida orci nisl, quis tristique dui consectetur eget. Donec at nisl ac libero imperdiet tempor et ac diam. Phasellus vitae nibh sed tortor fringilla placerat id at lacus.'),
(3, 'Vestibulum sapien metus, feugiat non nunc sed, laoreet luctus dolor.', 'Vestibulum nibh urna, rutrum sit amet sem ut, rhoncus tristique lectus. Etiam laoreet efficitur tincidunt. In hac habitasse platea dictumst. Integer fringilla mi quam. Cras enim orci, pharetra eu blandit id, tincidunt at justo. Nunc sed leo a sapien laoreet pretium eleifend eget purus. Sed in sapien quis diam posuere pharetra quis vel sapien. Sed sed aliquet neque, in rhoncus ex. Aliquam posuere euismod magna, ut consequat nulla placerat vitae. Aenean fringilla, tellus sed aliquet molestie, nisi urna aliquet quam, et tincidunt mauris quam vitae ligula. Nullam tristique mattis pretium. Pellentesque vel ultricies elit. Maecenas elementum magna dignissim ex molestie, quis fringilla leo venenatis. Donec ut velit eget ex commodo volutpat vitae non arcu. Aenean finibus ullamcorper justo, nec ullamcorper magna ullamcorper nec.');

-- --------------------------------------------------------

--
-- Table structure for table `project_owner_pivot`
--

CREATE TABLE `project_owner_pivot` (
  `project_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_owner_pivot`
--

INSERT INTO `project_owner_pivot` (`project_id`, `owner_id`) VALUES
(1, 1),
(2, 1),
(3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `project_status_pivot`
--

CREATE TABLE `project_status_pivot` (
  `project_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_status_pivot`
--

INSERT INTO `project_status_pivot` (`project_id`, `status_id`) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` int(11) NOT NULL,
  `key` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `key`, `name`) VALUES
(1, 'todo', 'Fejlesztésre vár'),
(2, 'in_progress', 'Folyamatban'),
(3, 'done', 'Kész');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `owners`
--
ALTER TABLE `owners`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `owner_email_UNIQUE` (`email`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_owner_pivot`
--
ALTER TABLE `project_owner_pivot`
  ADD KEY `fk_project_owner_pivot_projects1_idx` (`project_id`),
  ADD KEY `fk_project_owner_pivot_owners1_idx` (`owner_id`);

--
-- Indexes for table `project_status_pivot`
--
ALTER TABLE `project_status_pivot`
  ADD UNIQUE KEY `project_id_UNIQUE` (`project_id`),
  ADD KEY `fk_project_status_pivot_statuses1_idx` (`status_id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key_UNIQUE` (`key`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `owners`
--
ALTER TABLE `owners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `project_owner_pivot`
--
ALTER TABLE `project_owner_pivot`
  ADD CONSTRAINT `fk_project_owner_pivot_owners1` FOREIGN KEY (`owner_id`) REFERENCES `owners` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_project_owner_pivot_projects1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `project_status_pivot`
--
ALTER TABLE `project_status_pivot`
  ADD CONSTRAINT `fk_project_status_pivot_projects` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_project_status_pivot_statuses1` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
