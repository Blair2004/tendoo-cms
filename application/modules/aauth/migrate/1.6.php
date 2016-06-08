<?php
$this->db->query('ALTER TABLE `' . $this->db->dbprefix('aauth_groups') . '` ADD `description` TEXT NOT NULL AFTER `definition`;');
$this->db->query('ALTER TABLE `' . $this->db->dbprefix('aauth_perms') . '` ADD `description` TEXT NOT NULL AFTER `definition`;');
