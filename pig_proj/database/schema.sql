CREATE DATABASE IF NOT EXISTS pig_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE pig_db;

CREATE TABLE IF NOT EXISTS users (
  id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  username    VARCHAR(50)  NOT NULL,
  email       VARCHAR(255) NOT NULL UNIQUE,
  password    VARCHAR(255) NOT NULL,
  created_at  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS generation_sessions (
  id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id     INT UNSIGNED,
  name        VARCHAR(100),
  created_at  DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS number_sequences (
  id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  session_id      INT UNSIGNED,
  length          INT,
  min_value       INT,
  max_value       INT,
  is_sorted       ENUM('asc', 'desc', 'none') DEFAULT 'none',
  values_json     JSON,
  created_at      DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  FOREIGN KEY (session_id) REFERENCES generation_sessions(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS matrices (
  id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  session_id      INT UNSIGNED,
  row_count       INT,
  col_count       INT,
  min_value       INT,
  max_value       INT,
  `type`          ENUM('generic', 'map', 'special') DEFAULT 'generic',
  values_json     JSON,
  created_at      DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  FOREIGN KEY (session_id) REFERENCES generation_sessions(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS string_sequences (
  id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  session_id      INT UNSIGNED,
  length          INT,
  charset         VARCHAR(100),
  value           TEXT,
  created_at      DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  FOREIGN KEY (session_id) REFERENCES generation_sessions(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS graphs (
  id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  session_id      INT UNSIGNED,
  node_count      INT,
  edge_count      INT,
  is_directed     BOOLEAN DEFAULT FALSE,
  is_weighted     BOOLEAN DEFAULT FALSE,
  is_connected    BOOLEAN DEFAULT FALSE,
  is_bipartite    BOOLEAN DEFAULT FALSE,
  is_tree         BOOLEAN DEFAULT FALSE,
  representation  ENUM('edge_list', 'adjacency_matrix', 'parent_vector') DEFAULT 'edge_list',
  data_json       JSON,
  svg_representation TEXT, 
  created_at      DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  FOREIGN KEY (session_id) REFERENCES generation_sessions(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
