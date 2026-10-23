<?php
/**
 * Schema.org @type choices for global Organization / LocalBusiness JSON-LD.
 *
 * @package Spokora
 */

if ( ! defined( 'WPINC' ) ) {
	die( 'Access denied.' );
}

/**
 * Grouped business type options (schema.org type => label).
 *
 * @param string $text_domain Text domain for translated labels.
 * @return array<string, array<string, string>>
 */
function spokora_schema_type_choice_groups( $text_domain = 'spokora-free' ) {
	return array(
		__( 'General', $text_domain ) => array(
			'Organization'        => __( 'Organization (generic)', $text_domain ),
			'Corporation'         => __( 'Corporation / company', $text_domain ),
			'LocalBusiness'       => __( 'Local business (generic)', $text_domain ),
			'ProfessionalService' => __( 'Professional service / agency', $text_domain ),
			'OnlineBusiness'      => __( 'Online business (generic)', $text_domain ),
			'OnlineStore'         => __( 'Online store / e-commerce', $text_domain ),
		),
		__( 'Technology & software', $text_domain ) => array(
			'WebApplication'        => __( 'Web application / SaaS', $text_domain ),
			'SoftwareApplication'   => __( 'Desktop / downloadable software', $text_domain ),
			'MobileApplication'     => __( 'Mobile app (iOS / Android)', $text_domain ),
			'VideoGame'             => __( 'Video game / game studio', $text_domain ),
			'ResearchOrganization'  => __( 'Research / R&D organization', $text_domain ),
			'ComputerStore'         => __( 'Computer store', $text_domain ),
			'ElectronicsStore'      => __( 'Electronics store', $text_domain ),
			'MobilePhoneStore'      => __( 'Mobile phone store', $text_domain ),
			'InternetCafe'          => __( 'Internet café / coworking', $text_domain ),
		),
		__( 'Professional & financial', $text_domain ) => array(
			'AccountingService'  => __( 'Accounting / bookkeeping', $text_domain ),
			'FinancialService'   => __( 'Financial services', $text_domain ),
			'BankOrCreditUnion'  => __( 'Bank or credit union', $text_domain ),
			'InsuranceAgency'    => __( 'Insurance agency', $text_domain ),
			'LegalService'       => __( 'Legal services', $text_domain ),
			'Attorney'           => __( 'Attorney / law firm', $text_domain ),
			'Notary'             => __( 'Notary', $text_domain ),
			'RealEstateAgent'    => __( 'Real estate agent / brokerage', $text_domain ),
			'EmploymentAgency'   => __( 'Staffing / employment agency', $text_domain ),
			'TravelAgency'       => __( 'Travel agency', $text_domain ),
			'EngineeringService' => __( 'Engineering / technical consulting', $text_domain ),
		),
		__( 'Health & wellness', $text_domain ) => array(
			'Dentist'                   => __( 'Dentist', $text_domain ),
			'Physician'                 => __( 'Physician / doctor', $text_domain ),
			'MedicalClinic'             => __( 'Medical clinic', $text_domain ),
			'MedicalOrganization'       => __( 'Medical organization', $text_domain ),
			'Hospital'                  => __( 'Hospital', $text_domain ),
			'DiagnosticLab'             => __( 'Diagnostic lab', $text_domain ),
			'Pharmacy'                  => __( 'Pharmacy', $text_domain ),
			'Optician'                  => __( 'Optician / eye care', $text_domain ),
			'VeterinaryCare'            => __( 'Veterinary care', $text_domain ),
			'HealthAndBeautyBusiness'   => __( 'Health & beauty (generic)', $text_domain ),
			'DaySpa'                    => __( 'Day spa', $text_domain ),
			'HairSalon'                 => __( 'Hair salon', $text_domain ),
			'BeautySalon'               => __( 'Beauty salon', $text_domain ),
			'NailSalon'                 => __( 'Nail salon', $text_domain ),
			'TattooParlor'              => __( 'Tattoo parlor', $text_domain ),
			'ExerciseGym'               => __( 'Gym / fitness studio', $text_domain ),
			'HealthClub'                => __( 'Health club', $text_domain ),
		),
		__( 'Home, property & trades', $text_domain ) => array(
			'GeneralContractor'             => __( 'General contractor', $text_domain ),
			'Electrician'                   => __( 'Electrician', $text_domain ),
			'Plumber'                       => __( 'Plumber', $text_domain ),
			'HVACBusiness'                  => __( 'HVAC', $text_domain ),
			'RoofingContractor'             => __( 'Roofing', $text_domain ),
			'HousePainter'                  => __( 'House painter', $text_domain ),
			'Locksmith'                     => __( 'Locksmith', $text_domain ),
			'MovingCompany'                 => __( 'Moving company', $text_domain ),
			'LandscapingBusiness'           => __( 'Landscaping', $text_domain ),
			'HomeAndConstructionBusiness'   => __( 'Home & construction (generic)', $text_domain ),
			'SelfStorage'                   => __( 'Self storage', $text_domain ),
			'DryCleaningOrLaundry'          => __( 'Dry cleaning / laundry', $text_domain ),
			'RecyclingCenter'               => __( 'Recycling center', $text_domain ),
		),
		__( 'Retail', $text_domain ) => array(
			'Store'                => __( 'Retail store (generic)', $text_domain ),
			'GroceryStore'         => __( 'Grocery store', $text_domain ),
			'ConvenienceStore'     => __( 'Convenience store', $text_domain ),
			'DepartmentStore'      => __( 'Department store', $text_domain ),
			'WholesaleStore'       => __( 'Wholesale store', $text_domain ),
			'ClothingStore'        => __( 'Clothing store', $text_domain ),
			'ShoeStore'            => __( 'Shoe store', $text_domain ),
			'JewelryStore'         => __( 'Jewelry store', $text_domain ),
			'FurnitureStore'       => __( 'Furniture store', $text_domain ),
			'HomeGoodsStore'       => __( 'Home goods store', $text_domain ),
			'HardwareStore'        => __( 'Hardware store', $text_domain ),
			'SportingGoodsStore'   => __( 'Sporting goods store', $text_domain ),
			'HobbyShop'            => __( 'Hobby shop', $text_domain ),
			'BookStore'            => __( 'Bookstore', $text_domain ),
			'Florist'              => __( 'Florist', $text_domain ),
			'PetStore'             => __( 'Pet store', $text_domain ),
			'LiquorStore'          => __( 'Liquor store', $text_domain ),
			'BikeStore'            => __( 'Bike store', $text_domain ),
			'OutletStore'          => __( 'Outlet store', $text_domain ),
		),
		__( 'Food & drink', $text_domain ) => array(
			'Restaurant'           => __( 'Restaurant', $text_domain ),
			'CafeOrCoffeeShop'     => __( 'Café / coffee shop', $text_domain ),
			'Bakery'               => __( 'Bakery', $text_domain ),
			'BarOrPub'             => __( 'Bar or pub', $text_domain ),
			'FastFoodRestaurant'   => __( 'Fast food', $text_domain ),
			'IceCreamShop'         => __( 'Ice cream shop', $text_domain ),
			'Brewery'              => __( 'Brewery', $text_domain ),
			'Winery'               => __( 'Winery', $text_domain ),
			'Distillery'           => __( 'Distillery', $text_domain ),
			'FoodEstablishment'    => __( 'Food establishment (generic)', $text_domain ),
		),
		__( 'Hospitality & events', $text_domain ) => array(
			'Hotel'             => __( 'Hotel', $text_domain ),
			'Motel'             => __( 'Motel', $text_domain ),
			'BedAndBreakfast'   => __( 'Bed & breakfast', $text_domain ),
			'Resort'            => __( 'Resort', $text_domain ),
			'Campground'        => __( 'Campground', $text_domain ),
			'LodgingBusiness'   => __( 'Lodging (generic)', $text_domain ),
			'EventVenue'        => __( 'Event venue', $text_domain ),
		),
		__( 'Automotive', $text_domain ) => array(
			'AutomotiveBusiness' => __( 'Automotive business (generic)', $text_domain ),
			'AutoDealer'         => __( 'Auto dealer', $text_domain ),
			'MotorcycleDealer'   => __( 'Motorcycle dealer', $text_domain ),
			'AutoRepair'         => __( 'Auto repair', $text_domain ),
			'AutoBodyShop'       => __( 'Auto body shop', $text_domain ),
			'AutoPartsStore'     => __( 'Auto parts store', $text_domain ),
			'AutoRental'         => __( 'Auto rental', $text_domain ),
			'AutoWash'           => __( 'Car wash', $text_domain ),
			'GasStation'         => __( 'Gas station', $text_domain ),
			'TireShop'           => __( 'Tire shop', $text_domain ),
		),
		__( 'Education, government & community', $text_domain ) => array(
			'EducationalOrganization' => __( 'Educational organization', $text_domain ),
			'School'                  => __( 'School', $text_domain ),
			'Preschool'               => __( 'Preschool', $text_domain ),
			'ElementarySchool'        => __( 'Elementary school', $text_domain ),
			'MiddleSchool'            => __( 'Middle school', $text_domain ),
			'HighSchool'              => __( 'High school', $text_domain ),
			'CollegeOrUniversity'     => __( 'College or university', $text_domain ),
			'ChildCare'               => __( 'Child care / daycare', $text_domain ),
			'Library'                 => __( 'Library', $text_domain ),
			'NGO'                     => __( 'Nonprofit / NGO', $text_domain ),
			'GovernmentOrganization'  => __( 'Government organization', $text_domain ),
			'GovernmentOffice'        => __( 'Government office', $text_domain ),
			'ReligiousOrganization'   => __( 'Religious organization', $text_domain ),
			'Church'                  => __( 'Church', $text_domain ),
			'Mosque'                  => __( 'Mosque', $text_domain ),
			'Synagogue'               => __( 'Synagogue', $text_domain ),
			'SportsOrganization'      => __( 'Sports organization / club', $text_domain ),
		),
		__( 'Arts, media & entertainment', $text_domain ) => array(
			'NewsMediaOrganization' => __( 'News / media organization', $text_domain ),
			'RadioStation'          => __( 'Radio station', $text_domain ),
			'TelevisionStation'     => __( 'Television station', $text_domain ),
			'MovieTheater'          => __( 'Movie theater', $text_domain ),
			'PerformingArtsTheater' => __( 'Performing arts theater', $text_domain ),
			'ArtGallery'            => __( 'Art gallery', $text_domain ),
			'Museum'                => __( 'Museum', $text_domain ),
			'NightClub'             => __( 'Nightclub', $text_domain ),
			'ComedyClub'            => __( 'Comedy club', $text_domain ),
			'Casino'                => __( 'Casino', $text_domain ),
			'AmusementPark'         => __( 'Amusement park', $text_domain ),
			'Zoo'                   => __( 'Zoo', $text_domain ),
			'BowlingAlley'          => __( 'Bowling alley', $text_domain ),
			'GolfCourse'            => __( 'Golf course', $text_domain ),
			'StadiumOrArena'        => __( 'Stadium or arena', $text_domain ),
			'TouristAttraction'     => __( 'Tourist attraction', $text_domain ),
			'EntertainmentBusiness' => __( 'Entertainment business (generic)', $text_domain ),
		),
	);
}

/**
 * Flat list of allowed schema.org @type values.
 *
 * @return list<string>
 */
function spokora_schema_type_allowed_types() {
	static $cache = null;
	if ( null !== $cache ) {
		return $cache;
	}
	$cache = array();
	foreach ( spokora_schema_type_choice_groups() as $types ) {
		foreach ( array_keys( $types ) as $type ) {
			$cache[] = $type;
		}
	}
	return $cache;
}

/**
 * Sanitize a submitted schema type; keep unknown stored values on save.
 *
 * @param string $type Raw type.
 * @param string $default Fallback when invalid.
 * @return string
 */
function spokora_sanitize_schema_type( $type, $default = 'ProfessionalService' ) {
	$type = sanitize_text_field( (string) $type );
	if ( in_array( $type, spokora_schema_type_allowed_types(), true ) ) {
		return $type;
	}
	if ( '' !== $type && preg_match( '/^[A-Za-z][A-Za-z0-9]*$/', $type ) ) {
		$old = get_option( 'spokora_options', array() );
		if ( is_array( $old ) && isset( $old['schema_type'] ) && (string) $old['schema_type'] === $type ) {
			return $type;
		}
	}
	return $default;
}

/**
 * Echo a grouped <select> for business / schema type.
 *
 * @param string               $selected Current @type.
 * @param array<string, mixed> $args     name, id, class, style, text_domain.
 */
function spokora_render_schema_type_select( $selected, $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'name'        => 'schema_type',
			'id'          => 'schema_type',
			'class'       => '',
			'style'       => '',
			'text_domain' => 'spokora-free',
			'show_saved'  => true,
		)
	);
	$selected = is_string( $selected ) ? $selected : '';
	if ( '' === $selected ) {
		$selected = 'ProfessionalService';
	}
	$allowed = spokora_schema_type_allowed_types();
	$extra   = ( $args['show_saved'] && '' !== $selected && ! in_array( $selected, $allowed, true ) );
	$name    = (string) $args['name'];
	$id      = (string) $args['id'];
	$class   = (string) $args['class'];
	$style   = (string) $args['style'];
	$td      = (string) $args['text_domain'];

	echo '<select name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '"';
	if ( '' !== $class ) {
		echo ' class="' . esc_attr( $class ) . '"';
	}
	if ( '' !== $style ) {
		echo ' style="' . esc_attr( $style ) . '"';
	}
	echo '>';
	if ( $extra ) {
		echo '<option value="' . esc_attr( $selected ) . '" selected="selected">';
		echo esc_html(
			sprintf(
				/* translators: %s: schema.org type name */
				__( 'Saved type: %s', $td ),
				$selected
			)
		);
		echo '</option>';
	}
	foreach ( spokora_schema_type_choice_groups( $td ) as $group_label => $types ) {
		echo '<optgroup label="' . esc_attr( $group_label ) . '">';
		foreach ( $types as $value => $label ) {
			printf(
				'<option value="%1$s" %2$s>%3$s</option>',
				esc_attr( $value ),
				selected( $selected, $value, false ),
				esc_html( $label )
			);
		}
		echo '</optgroup>';
	}
	echo '</select>';
}
