-- Initialize schema and table
CREATE TABLE IF NOT EXISTS products (
  id VARCHAR(64) PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  brand VARCHAR(255) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  image VARCHAR(512) NOT NULL,
  sub VARCHAR(64) NOT NULL,
  category VARCHAR(64) NOT NULL
);

INSERT INTO products (id, name, brand, price, image, sub, category) VALUES
  ('rg2','Torriden Dive-In Mask','Torriden',3.50,'images/anh/rg2.jpg','skincare','beauty'),
  ('rg3','I\'m from Fig Scrub Mask','I\'m From',32.00,'images/anh/rg3.jpg','skincare','beauty'),
  ('rg1','La Mer Treatment Lotion','La Mer',175.00,'images/anh/rg1.jpg','skincare','beauty'),
  ('sp5','Velvet Lip Tint','Rom&nd',12.00,'images/anh/sp5.jpg','makeup','beauty'),
  ('weekly7','Denim Collar Blouse Set','Chuu',45.00,'images/anh/weekly7.jpg','tops','women'),
  ('weekly8','Puff Sleeve Knit Top','STYLENANDA',38.00,'images/anh/weekly8.jpg','tops','women'),
  ('weekly11','Turtleneck & Vest Set','YesStyle',52.00,'images/anh/weekly11.jpg','dresses','women'),
  ('weekly1','Brown Knit Polo','Ben-Haru',35.00,'images/anh/weekly1.jpg','shirts','men'),
  ('men1','Black Wide-Leg Trousers','Yin-Yang',55.00,'images/anh/men1.jpg','pants','men'),
  ('men2','Minimalist Windbreaker','Gen-Z',68.00,'images/anh/men2.jpg','shirts','men'),
  ('sp2','Canvas Eco Tote Bag','Evergreen',15.00,'images/anh/sp2.jpg','fashion','lifestyle')
ON DUPLICATE KEY UPDATE name=VALUES(name);

