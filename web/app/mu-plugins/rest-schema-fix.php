<?php
/**
 * Fix invalid REST schema "type" values in block attribute metadata during server-side rendering.
 *
 * Some blocks define attribute schemas with types like "rich-text" which are valid in block.json
 * but not valid JSON Schema types for rest_validate_value_from_schema(), causing noisy notices
 * when WP_DEBUG_DISPLAY is enabled.
 */

if (!defined('ABSPATH')) {
	exit;
}

add_filter(
	'block_type_metadata_settings',
	static function (array $settings, array $metadata): array {
		if (empty($settings['attributes']) || !is_array($settings['attributes'])) {
			return $settings;
		}

		foreach ($settings['attributes'] as $attr_name => $attr_schema) {
			if (!is_array($attr_schema)) {
				continue;
			}

			// "rich-text" is used by several core blocks (e.g. core/button) but is not a REST schema type.
			if (($attr_schema['type'] ?? null) === 'rich-text') {
				$attr_schema['type'] = 'string';
				$settings['attributes'][$attr_name] = $attr_schema;
			}
		}

		return $settings;
	},
	10,
	2
);





