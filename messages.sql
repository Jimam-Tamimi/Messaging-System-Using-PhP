--
-- Database: `messages`
--
CREATE DATABASE IF NOT EXISTS `messages` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `messages`;

-- --------------------------------------------------------

--
-- Table structure for table `chat_rooms`
--

CREATE TABLE `chat_rooms` (
  `id` bigint(15) NOT NULL,
  `user_id_1` bigint(15) NOT NULL,
  `user_id_2` bigint(15) NOT NULL,
  `dt` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(15) NOT NULL,
  `chat_room_id` bigint(15) NOT NULL,
  `sender_id` bigint(15) NOT NULL,
  `receiver_id` bigint(15) NOT NULL,
  `message` text NOT NULL,
  `seen` tinyint(1) NOT NULL,
  `position` bigint(50) NOT NULL,
  `dt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(15) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `profile_img` text NOT NULL,
  `dt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat_rooms`
--
ALTER TABLE `chat_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat_rooms`
--
ALTER TABLE `chat_rooms`
  MODIFY `id` bigint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- Database: `phpmyadmin`
--