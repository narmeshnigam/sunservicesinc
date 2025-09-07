-- Seed data for Sun Services Inc website

INSERT INTO `users` (`name`, `email`, `password_plain`, `role`, `status`, `created_at`, `updated_at`)
VALUES
  ('Administrator', 'admin@sunservicesinc.in', 'admin123', 'Admin', 'Active', NOW(), NOW());

-- Sample leads
INSERT INTO `leads` (`name`, `mobile`, `email`, `service`, `sub_service`, `city`, `pincode`, `preferred_at`, `message`, `source_page`, `created_at`)
VALUES
  ('Rahul Kumar', '9876543210', 'rahul@example.com', 'Cleaning', 'Carpet Cleaning', 'Delhi', '110001', NOW(), 'Need carpet cleaning for 3 rooms.', '/services/carpet-cleaning.php', NOW()),
  ('Anita Sharma', '9123456789', 'anita@example.com', 'Flooring', 'Laminate Flooring', 'Mumbai', '400001', NOW(), 'Quote for laminate flooring installation.', '/services/laminate-flooring.php', NOW());