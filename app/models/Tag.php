<?php
class Tag {
    /**
     * Extracts and aggregates popular tags from the images table
     * This is useful for automated internal linking without needing a separate tags table join query.
     */
    public static function getPopular($limit = 20) {
        // In a highly scaled production DB, a separate `tags` aggregate table is better.
        // For this architecture, we extract directly or mock it based on the phase specs.
        $sql = "SELECT tags FROM images WHERE tags IS NOT NULL AND tags != '' ORDER BY downloads DESC LIMIT 100";
        $results = Database::fetchAll($sql);

        $tagCounts = [];
        foreach ($results as $row) {
            $tags = array_map('trim', explode(',', $row['tags']));
            foreach ($tags as $tag) {
                if (empty($tag)) continue;
                $tagLower = strtolower($tag);
                if (!isset($tagCounts[$tagLower])) {
                    $tagCounts[$tagLower] = ['name' => $tag, 'count' => 0];
                }
                $tagCounts[$tagLower]['count']++;
            }
        }

        // Sort by count descending
        uasort($tagCounts, function($a, $b) {
            return $b['count'] <=> $a['count'];
        });

        return array_slice($tagCounts, 0, (int)$limit);
    }
}
