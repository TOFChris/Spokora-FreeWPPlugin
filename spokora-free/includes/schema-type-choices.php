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
 * @return array<string, array<string, string>>
 */
function spokora_schema_type_choice_groups() {
	return array(
		__( 'General', 'spokora-free' ) => array(
			'Organization'        => __( 'Organization (generic)', 'spokora-free' ),
			'Corporation'         => __( 'Corporation / company', 'spokora-free' ),
			'LocalBusiness'       => __( 'Local business (generic)', 'spokora-free' ),
			'ProfessionalService' => __( 'Professional service / agency', 'spokora-free' ),
			'OnlineBusiness'      => __( 'Online business (generic)', 'spokora-free' ),
			'OnlineStore'         => __( 'Online store / e-commerce', 'spokora-free' ),
		),
		__( 'Technology & software', 'spokora-free' ) => array(
			'WebApplication'        => __( 'Web application / SaaS', 'spokora-free' ),
			'SoftwareApplication'   => __( 'Desktop / downloadable software', 'spokora-free' ),
			'MobileApplication'     => __( 'Mobile app (iOS / Android)', 'spokora-free' ),
			'VideoGame'             => __( 'Video game / game studio', 'spokora-free' ),
			'ResearchOrganization'  => __( 'Research / R&D organization', 'spokora-free' ),
			'ComputerStore'         => __( 'Computer store', 'spokora-free' ),
			'ElectronicsStore'      => __( 'Electronics store', 'spokora-free' ),
			'MobilePhoneStore'      => __( 'Mobile phone store', 'spokora-free' ),
			'InternetCafe'          => __( 'Internet café / coworking', 'spokora-free' ),
		),
		__( 'Professional & financial', 'spokora-free' ) => array(
			'AccountingService'  => __( 'Accounting / bookkeeping', 'spokora-free' ),
			'FinancialService'   => __( 'Financial services', 'spokora-free' ),
			'BankOrCreditUnion'  => __( 'Bank or credit union', 'spokora-free' ),
			'InsuranceAgency'    => __( 'Insurance agency', 'spokora-free' ),
			'LegalService'       => __( 'Legal services', 'spokora-free' ),
			'Attorney'           => __( 'Attorney / law firm', 'spokora-free' ),
			'Notary'             => __( 'Notary', 'spokora-free' ),
			'RealEstateAgent'    => __( 'Real estate agent / brokerage', 'spokora-free' ),
			'EmploymentAgency'   => __( 'Staffing / employment agency', 'spokora-free' ),
			'TravelAgency'       => __( 'Travel agency', 'spokora-free' ),
			'EngineeringService' => __( 'Engineering / technical consulting', 'spokora-free' ),
		),
		__( 'Health & wellness', 'spokora-free' ) => array(
			'Dentist'                   => __( 'Dentist', 'spokora-free' ),
			'Physician'                 => __( 'Physician / doctor', 'spokora-free' ),
			'MedicalClinic'             => __( 'Medical clinic', 'spokora-free' ),
			'MedicalOrganization'       => __( 'Medical organization', 'spokora-free' ),
			'Hospital'                  => __( 'Hospital', 'spokora-free' ),
			'DiagnosticLab'             => __( 'Diagnostic lab', 'spokora-free' ),
			'Pharmacy'                  => __( 'Pharmacy', 'spokora-free' ),
			'Optician'                  => __( 'Optician / eye care', 'spokora-free' ),
			'VeterinaryCare'            => __( 'Veterinary care', 'spokora-free' ),
			'HealthAndBeautyBusiness'   => __( 'Health & beauty (generic)', 'spokora-free' ),
			'DaySpa'                    => __( 'Day spa', 'spokora-free' ),
			'HairSalon'                 => __( 'Hair salon', 'spokora-free' ),
			'BeautySalon'               => __( 'Beauty salon', 'spokora-free' ),
			'NailSalon'                 => __( 'Nail salon', 'spokora-free' ),
			'TattooParlor'              => __( 'Tattoo parlor', 'spokora-free' ),
			'ExerciseGym'               => __( 'Gym / fitness studio', 'spokora-free' ),
			'HealthClub'                => __( 'Health club', 'spokora-free' ),
		),
		__( 'Home, property & trades', 'spokora-free' ) => array(
			'GeneralContractor'             => __( 'General contractor', 'spokora-free' ),
			'Electrician'                   => __( 'Electrician', 'spokora-free' ),
			'Plumber'                       => __( 'Plumber', 'spokora-free' ),
			'HVACBusiness'                  => __( 'HVAC', 'spokora-free' ),
			'RoofingContractor'             => __( 'Roofing', 'spokora-free' ),
			'HousePainter'                  => __( 'House painter', 'spokora-free' ),
			'Locksmith'                     => __( 'Locksmith', 'spokora-free' ),
			'MovingCompany'                 => __( 'Moving company', 'spokora-free' ),
			'LandscapingBusiness'           => __( 'Landscaping', 'spokora-free' ),
			'HomeAndConstructionBusiness'   => __( 'Home & construction (generic)', 'spokora-free' ),
			'SelfStorage'                   => __( 'Self storage', 'spokora-free' ),
			'DryCleaningOrLaundry'          => __( 'Dry cleaning / laundry', 'spokora-free' ),
			'RecyclingCenter'               => __( 'Recycling center', 'spokora-free' ),
		),
		__( 'Retail', 'spokora-free' ) => array(
			'Store'                => __( 'Retail store (generic)', 'spokora-free' ),
			'GroceryStore'         => __( 'Grocery store', 'spokora-free' ),
			'ConvenienceStore'     => __( 'Convenience store', 'spokora-free' ),
			'DepartmentStore'      => __( 'Department store', 'spokora-free' ),
			'WholesaleStore'       => __( 'Wholesale store', 'spokora-free' ),
			'ClothingStore'        => __( 'Clothing store', 'spokora-free' ),
			'ShoeStore'            => __( 'Shoe store', 'spokora-free' ),
			'JewelryStore'         => __( 'Jewelry store', 'spokora-free' ),
			'FurnitureStore'       => __( 'Furniture store', 'spokora-free' ),
			'HomeGoodsStore'       => __( 'Home goods store', 'spokora-free' ),
			'HardwareStore'        => __( 'Hardware store', 'spokora-free' ),
			'SportingGoodsStore'   => __( 'Sporting goods store', 'spokora-free' ),
			'HobbyShop'            => __( 'Hobby shop', 'spokora-free' ),
			'BookStore'            => __( 'Bookstore', 'spokora-free' ),
			'Florist'              => __( 'Florist', 'spokora-free' ),
			'PetStore'             => __( 'Pet store', 'spokora-free' ),
			'LiquorStore'          => __( 'Liquor store', 'spokora-free' ),
			'BikeStore'            => __( 'Bike store', 'spokora-free' ),
			'OutletStore'          => __( 'Outlet store', 'spokora-free' ),
		),
		__( 'Food & drink', 'spokora-free' ) => array(
			'Restaurant'           => __( 'Restaurant', 'spokora-free' ),
			'CafeOrCoffeeShop'     => __( 'Café / coffee shop', 'spokora-free' ),
			'Bakery'               => __( 'Bakery', 'spokora-free' ),
			'BarOrPub'             => __( 'Bar or pub', 'spokora-free' ),
			'FastFoodRestaurant'   => __( 'Fast food', 'spokora-free' ),
			'IceCreamShop'         => __( 'Ice cream shop', 'spokora-free' ),
			'Brewery'              => __( 'Brewery', 'spokora-free' ),
			'Winery'               => __( 'Winery', 'spokora-free' ),
			'Distillery'           => __( 'Distillery', 'spokora-free' ),
			'FoodEstablishment'    => __( 'Food establishment (generic)', 'spokora-free' ),
		),
		__( 'Hospitality & events', 'spokora-free' ) => array(
			'Hotel'             => __( 'Hotel', 'spokora-free' ),
			'Motel'             => __( 'Motel', 'spokora-free' ),
			'BedAndBreakfast'   => __( 'Bed & breakfast', 'spokora-free' ),
			'Resort'            => __( 'Resort', 'spokora-free' ),
			'Campground'        => __( 'Campground', 'spokora-free' ),
			'LodgingBusiness'   => __( 'Lodging (generic)', 'spokora-free' ),
			'EventVenue'        => __( 'Event venue', 'spokora-free' ),
		),
		__( 'Automotive', 'spokora-free' ) => array(
			'AutomotiveBusiness' => __( 'Automotive business (generic)', 'spokora-free' ),
			'AutoDealer'         => __( 'Auto dealer', 'spokora-free' ),
			'MotorcycleDealer'   => __( 'Motorcycle dealer', 'spokora-free' ),
			'AutoRepair'         => __( 'Auto repair', 'spokora-free' ),
			'AutoBodyShop'       => __( 'Auto body shop', 'spokora-free' ),
			'AutoPartsStore'     => __( 'Auto parts store', 'spokora-free' ),
			'AutoRental'         => __( 'Auto rental', 'spokora-free' ),
			'AutoWash'           => __( 'Car wash', 'spokora-free' ),
			'GasStation'         => __( 'Gas station', 'spokora-free' ),
			'TireShop'           => __( 'Tire shop', 'spokora-free' ),
		),
		__( 'Education, government & community', 'spokora-free' ) => array(
			'EducationalOrganization' => __( 'Educational organization', 'spokora-free' ),
			'School'                  => __( 'School', 'spokora-free' ),
			'Preschool'               => __( 'Preschool', 'spokora-free' ),
			'ElementarySchool'        => __( 'Elementary school', 'spokora-free' ),
			'MiddleSchool'            => __( 'Middle school', 'spokora-free' ),
			'HighSchool'              => __( 'High school', 'spokora-free' ),
			'CollegeOrUniversity'     => __( 'College or university', 'spokora-free' ),
			'ChildCare'               => __( 'Child care / daycare', 'spokora-free' ),
			'Library'                 => __( 'Library', 'spokora-free' ),
			'NGO'                     => __( 'Nonprofit / NGO', 'spokora-free' ),
			'GovernmentOrganization'  => __( 'Government organization', 'spokora-free' ),
			'GovernmentOffice'        => __( 'Government office', 'spokora-free' ),
			'ReligiousOrganization'   => __( 'Religious organization', 'spokora-free' ),
			'Church'                  => __( 'Church', 'spokora-free' ),
			'Mosque'                  => __( 'Mosque', 'spokora-free' ),
			'Synagogue'               => __( 'Synagogue', 'spokora-free' ),
			'SportsOrganization'      => __( 'Sports organization / club', 'spokora-free' ),
		),
		__( 'Arts, media & entertainment', 'spokora-free' ) => array(
			'NewsMediaOrganization' => __( 'News / media organization', 'spokora-free' ),
			'RadioStation'          => __( 'Radio station', 'spokora-free' ),
			'TelevisionStation'     => __( 'Television station', 'spokora-free' ),
			'MovieTheater'          => __( 'Movie theater', 'spokora-free' ),
			'PerformingArtsTheater' => __( 'Performing arts theater', 'spokora-free' ),
			'ArtGallery'            => __( 'Art gallery', 'spokora-free' ),
			'Museum'                => __( 'Museum', 'spokora-free' ),
			'NightClub'             => __( 'Nightclub', 'spokora-free' ),
			'ComedyClub'            => __( 'Comedy club', 'spokora-free' ),
			'Casino'                => __( 'Casino', 'spokora-free' ),
			'AmusementPark'         => __( 'Amusement park', 'spokora-free' ),
			'Zoo'                   => __( 'Zoo', 'spokora-free' ),
			'BowlingAlley'          => __( 'Bowling alley', 'spokora-free' ),
			'GolfCourse'            => __( 'Golf course', 'spokora-free' ),
			'StadiumOrArena'        => __( 'Stadium or arena', 'spokora-free' ),
			'TouristAttraction'     => __( 'Tourist attraction', 'spokora-free' ),
			'EntertainmentBusiness' => __( 'Entertainment business (generic)', 'spokora-free' ),
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
 * @param array<string, mixed> $args name, id, class, style.
 */
function spokora_render_schema_type_select( $selected, $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'name'        => 'schema_type',
			'id'          => 'schema_type',
			'class'       => '',
			'style'       => '',
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
				__( 'Saved type: %s', 'spokora-free' ),
				$selected
			)
		);
		echo '</option>';
	}
	foreach ( spokora_schema_type_choice_groups() as $group_label => $types ) {
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
