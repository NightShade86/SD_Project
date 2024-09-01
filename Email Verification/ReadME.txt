1. Add a Primary Key to user_info

ALTER TABLE `user_info`
ADD COLUMN `id` INT AUTO_INCREMENT PRIMARY KEY FIRST;

2. Create email_verification_tokens Table

CREATE TABLE `email_verification_tokens` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `token` VARCHAR(255) NOT NULL,
    `expires_at` DATETIME NOT NULL,
    FOREIGN KEY (`user_id`) REFERENCES `user_info`(`id`)
);

3. See "ViewME.png" , "ViewME_2.png" 