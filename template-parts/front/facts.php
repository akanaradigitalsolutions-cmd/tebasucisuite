<?php
/**
 * Homepage: highlights band.
 *
 * @package TebaSuci
 */

if ( ! tebasuci_show( 'facts' ) ) {
	return;
}

$tebasuci_facts = array();
for ( $tebasuci_i = 1; $tebasuci_i <= 4; $tebasuci_i++ ) {
	$tebasuci_value = (string) tebasuci_get( "fact_{$tebasuci_i}_value" );
	$tebasuci_label = (string) tebasuci_get( "fact_{$tebasuci_i}_label" );
	if ( '' === $tebasuci_value && '' === $tebasuci_label ) {
		continue;
	}
	$tebasuci_facts[] = array(
		'value'  => $tebasuci_value,
		'suffix' => (string) tebasuci_get( "fact_{$tebasuci_i}_suffix" ),
		'label'  => $tebasuci_label,
	);
}

if ( ! $tebasuci_facts ) {
	return;
}
?>
<section class="facts-band facts-band--<?php echo (int) count( $tebasuci_facts ); ?>" id="highlights" aria-label="<?php esc_attr_e( 'Highlights', 'tebasuci' ); ?>">
	<?php foreach ( $tebasuci_facts as $tebasuci_fact ) : ?>
		<div class="fact-item">
			<?php if ( '' !== $tebasuci_fact['value'] ) : ?>
				<strong>
					<?php echo esc_html( $tebasuci_fact['value'] ); ?>
					<?php if ( '' !== $tebasuci_fact['suffix'] ) : ?>
						<small><?php echo esc_html( $tebasuci_fact['suffix'] ); ?></small>
					<?php endif; ?>
				</strong>
			<?php endif; ?>
			<?php if ( '' !== $tebasuci_fact['label'] ) : ?>
				<span><?php echo esc_html( $tebasuci_fact['label'] ); ?></span>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
</section>
