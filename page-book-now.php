<?php
/**
 * Template used for pages.
 *
 * @package Avada
 * @subpackage Templates
 */

$fields = get_fields();

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<?php get_header(); ?>
<section id="content" <?php Avada()->layout->add_style( 'content_style' ); ?>>
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="post-content">
				<?php //the_content(); ?>

				<div id="booking-form" class="booking-form">
			        <div class="tab-header">
			            <div class="steps">
    			            <div id="step-1" class="step-item" :class="{ current: page === 1, done: page > 1 }">
    			                <div class="icon"></div>
    			                <p>Treatment details</p>
    			            </div>
                            <div id="step-2" class="step-item" :class="{ current: page === 2, done: page > 2 }">
    			                <div class="icon"></div>
    			                 <p>Date & time</p>
    			            </div>
                            <div id="step-3" class="step-item" :class="{ current: page === 3, done: page > 3 }">
    			               <div class="icon"></div>
    			               <p>Confirmation</p>
    			            </div>
			            </div>
			        </div>
			        <div class="tab-contents">
			            <div class="fusion-row">
			                <form class="booking">
        			            <div class="form-tab">
        			                <div class="booking-info">
                                        <transition name="fade" mode="out-in">
                                            <div id="tab-1" class="tab-content" v-if="page === 1" key="tab-1">
                                                <button type="button" @click="autofill">Auto fill form</button>
                                                <button type="button" @click="continueToPage2">Next page</button>
                                                <div class="tab-wrapper">
                                                    <div class="tab-item">
                                                        <?php
                                                        $question_1 = get_field('question_1', 'option');
                                                        if( $question_1  ): ?>
                                                            <h3>
                                                                <?php echo esc_attr( $question_1['question'] ); ?>
                                                                <?php  if( $question_1['help_icon'] ) { ?>
                                                                <div class="help">
                                                                    <span>?</span>
                                                                    <div class="help-content">
                                                                        <?php echo  $question_1['help_icon']; ?>
                                                                    </div>
                                                                </div>
                                                                <?php } ?>
                                                            </h3>
                                                        <?php endif; ?>

                                                        <div class="button-list">
                                                            <button
                                                                    class="service-button"
                                                                    :class="{active: form.treatmentType === option}"
                                                                    v-for="option in options.treatments"
                                                                    type="button"
                                                                    @click="updateField('treatmentType', option)">
                                                                {{ option.name }}
                                                            </button>
                                                        </div>

                                                        <transition name="fade">
                                                            <div class="validation-error" v-if="errors.treatmentType">
                                                                {{ errors.treatmentType }}
                                                            </div>
                                                        </transition>
                                                    </div>
                                                    <div class="tab-item">
                                                        <?php
                                                        $question_2 = get_field('question_2', 'option');
                                                        if( $question_2  ): ?>
                                                            <h3>
                                                                <?php echo esc_attr( $question_2['question'] ); ?>
                                                                <?php  if( $question_2['help_icon'] ) { ?>
                                                                <div class="help">
                                                                    <span>?</span>
                                                                    <div class="help-content">
                                                                        <?php echo  $question_2['help_icon']; ?>
                                                                    </div>
                                                                </div>
                                                                <?php } ?>
                                                            </h3>
                                                        <?php endif; ?>

                                                        <div class="button-list">
                                                            <button
                                                                    class="service-button"
                                                                    :class="{active: form.bodyArea === option}"
                                                                    v-for="option in options.bodyArea"
                                                                    type="button"
                                                                    @click="updateField('bodyArea', option)">
                                                                {{ option.body_parts }}
                                                            </button>
                                                        </div>

                                                        <transition name="fade">
                                                            <div class="validation-error" v-if="errors.bodyArea">
                                                                {{ errors.bodyArea }}
                                                            </div>
                                                        </transition>
                                                    </div>
                                                    <div class="tab-item">
                                                        <?php
                                                            $question_3 = get_field('question_3', 'option');
                                                            if( $question_3  ): ?>
                                                                <h3><?php echo esc_attr( $question_3['question'] ); ?></h3>
                                                        <?php endif; ?>

                                                        <div class="color-list">
                                                            <button
                                                                    class="tone-button"
                                                                    :class="{active: form.skinTone === option}"
                                                                    v-for="option in options.skinTone"
                                                                    type="button"
                                                                    @click="updateField('skinTone', option)">
                                                                <span :style="{ background: option.code }"></span>
                                                            </button>
                                                        </div>

                                                        <transition name="fade">
                                                            <div class="validation-error" v-if="errors.skinTone">
                                                                {{ errors.skinTone }}
                                                            </div>
                                                        </transition>

                                                        <?php if ( $question_3['additional_color'] ){ ?>
                                                        <label class="not-listed"><?php echo esc_attr( $question_3['additional_color'] ); ?>
                                                            <div class="help">
                                                                <span>?</span>
                                                                <div class="help-content">
                                                                    <?php echo  $question_3['help_icon']; ?>
                                                                </div>
                                                            </div>
                                                        </label>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="tab-item">
                                                        <?php
                                                            $question_4 = get_field('question_4', 'option');
                                                            if( $question_4  ): ?>
                                                                <h3><?php echo esc_attr( $question_4['question'] ); ?></h3>
                                                        <?php endif; ?>

                                                        <div class="color-list">
                                                            <button
                                                                    class="tone-button"
                                                                    :class="{active: form.hairColour === option}"
                                                                    v-for="option in options.hairColour"
                                                                    type="button"
                                                                    @click="updateField('hairColour', option)">
                                                                <span :style="{ background: option.code }"></span>
                                                            </button>
                                                        </div>

                                                        <transition name="fade">
                                                            <div class="validation-error" v-if="errors.hairColour">
                                                                {{ errors.hairColour }}
                                                            </div>
                                                        </transition>

                                                        <?php if ( $question_4['additional_color'] ){ ?>
                                                        <label class="not-listed"><?php echo esc_attr( $question_4['additional_color'] ); ?>
                                                             <div class="help">
                                                                <span>?</span>
                                                                <div class="help-content">
                                                                    <?php echo  $question_4['help_icon']; ?>
                                                                </div>
                                                            </div>
                                                        </label>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="tab-item">
                                                        <?php
                                                        $question_5 = get_field('question_5', 'option');
                                                        if( $question_5  ): ?>
                                                            <h3>
                                                                <?php echo esc_attr( $question_5['question'] ); ?>
                                                                <?php  if( $question_5['help_icon'] ) { ?>
                                                                <div class="help">
                                                                    <span>?</span>
                                                                    <div class="help-content">
                                                                        <?php echo  $question_5['help_icon']; ?>
                                                                    </div>
                                                                </div>
                                                                <?php } ?>
                                                            </h3>
                                                        <?php endif; ?>

                                                        <div class="option-list">
                                                            <select v-model="form.skinReaction" @change="inputChanged('skinReaction')">
                                                                <option :value="null">Please select</option>
                                                                <option v-for="option in options.skinReaction" :value="option">{{ option.option }}</option>
                                                            </select>
                                                        </div>

                                                        <transition name="fade">
                                                            <div class="validation-error" v-if="errors.skinReaction">
                                                                {{ errors.skinReaction }}
                                                            </div>
                                                        </transition>
                                                    </div>
                                                    <div class="tab-item">
                                                        <?php
                                                        $question_6 = get_field('question_6', 'option');
                                                        if( $question_6  ): ?>
                                                            <h3>
                                                                <?php echo esc_attr( $question_6['question'] ); ?>
                                                                <?php  if( $question_6['help_icon'] ) { ?>
                                                                <div class="help">
                                                                    <span>?</span>
                                                                    <div class="help-content">
                                                                        <?php echo  $question_6['help_icon']; ?>
                                                                    </div>
                                                                </div>
                                                                <?php } ?>
                                                            </h3>
                                                        <?php endif; ?>

                                                        <div class="option-list">
                                                            <select v-model="form.heritage" @change="inputChanged('heritage')">
                                                                <option :value="null">Please select</option>
                                                                <option v-for="option in options.heritage" :value="option">{{ option.option }}</option>
                                                            </select>
                                                        </div>

                                                        <transition name="fade">
                                                            <div class="validation-error" v-if="errors.heritage">
                                                                {{ errors.heritage }}
                                                            </div>
                                                        </transition>
                                                    </div>
                                                    <div class="tab-item" v-if="form.treatmentType">
                                                        <?php
                                                        $question_7 = get_field('question_7', 'option');
                                                        if( $question_7  ): ?>
                                                            <h3>
                                                                <?php echo esc_attr( $question_7['question'] ); ?>
                                                                <?php  if( $question_7['help_icon'] ) { ?>
                                                                <div class="help">
                                                                    <span>?</span>
                                                                    <div class="help-content">
                                                                        <?php echo  $question_7['help_icon']; ?>
                                                                    </div>
                                                                </div>
                                                                <?php } ?>
                                                            </h3>
                                                        <?php endif; ?>

                                                        <div class="treatment-list">
                                                            <ul class="service-list show">
                                                                <li v-for="treatment in form.treatmentType.services">
                                                                    <p>
                                                                        {{ treatment.name }}
                                                                        <span>{{ treatment.duration }}</span>
                                                                    </p>
                                                                    <button
                                                                            class="add-button"
                                                                            :class="{ selected: form.treatments.includes(treatment) }"
                                                                            type="button"
                                                                            @click="toggleTreatment(treatment, form.treatmentType.name)">
                                                                        {{ form.treatments.includes(treatment) ? 'Remove' : 'Add' }}
                                                                    </button>
                                                                </li>
                                                            </ul>
                                                        </div>

                                                        <transition name="fade">
                                                            <div class="validation-error" v-if="errors.treatments">
                                                                {{ errors.treatments }}
                                                            </div>
                                                        </transition>
                                                    </div>
                                                </div>
                                                <button type="button" class="next" @click="continueToPage2">Next</button>

                                                <transition name="fade">
                                                    <div class="validation-error" v-if="Object.values(errors).filter(error => error).length > 0" style="margin-top: 5px;">
                                                        Please answer all of the questions on this page.
                                                    </div>
                                                </transition>

                                            </div>
                                            <div id="tab-2" class="tab-content" v-if="page === 2" key="tab-2">
                                                <div class="tab-wrapper">
                                                    <div class="tab-item">
                                                        <h3>Personal information.</h3>
                                                        <div class="info-list">
                                                            <input type="text" name="name" placeholder="Name" v-model="form.name" @change="inputChanged('name')">
                                                            <input type="text" name="phone" placeholder="Phone" v-model="form.phone" @change="inputChanged('phone')">
                                                            <input type="text" name="email" placeholder="Email" v-model="form.email" @change="inputChanged('email')">
                                                        </div>
                                                        <transition name="fade">
                                                            <div class="validation-error" v-if="errors.personalInformation">
                                                                {{ errors.personalInformation }}
                                                            </div>
                                                        </transition>
                                                    </div>
                                                    <div class="tab-item">
                                                        <h3>Select date and time.</h3>

                                                        <transition name="fade">
                                                            <div class="validation-error" v-if="errors.dateAndTime" style="margin-bottom: 20px;">
                                                                {{ errors.dateAndTime }}
                                                            </div>
                                                        </transition>

                                                        <div class="selected-list show">
                                                            <div class="selected-item show" v-for="treatment in form.treatments">
                                                                <h3><span>Treatment:</span> {{ treatment.name }}</h3>
                                                                <div class="selected-date">
                                                                    <div class="date">
                                                                        <label>Select a Date</label>
                                                                        <vuejs-datepicker v-model="treatment.date" :disabled-dates="{to: new Date() }" @change="dateTimeInputChanged"></vuejs-datepicker>
                                                                    </div>
                                                                    <div class="time">
                                                                        <label>Select a Time</label>
                                                                        <select class="select-time" v-model="treatment.time" @change="dateTimeInputChanged">
                                                                            <option :value="time.date" v-for="time in timeSlots">
                                                                                {{ time.label }}
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="button" class="back" @click="goBackToPage1">BACK</button>
                                            </div>
                                            <div id="tab-3" class="tab-content" v-if="page === 3" key="tab-3">
                                                <div class="confirmation-message">
                                                    <h3>Thank you for booking with us.</h3>
                                                    <p>We’ll be in touch with you shortly.</p>
                                                    <a href="/">Back to Home</a>
                                                </div>
                                            </div>
                                        </transition>
                    				</div>
                    				<div id="booking-sidebar" class="booking-sidebar">
                    					<div class="booking-summary">
                    						<div class="summary-header">
                    							<h3>Booking Summary.</h3>
                                                <transition name="fade">
                                                    <a href="#" class="back" v-if="page === 2" @click.prevent="goBackToPage1">Change or add more treatments</a>
                                                </transition>
                    						</div>
                    						<div class="summary-content">
                    							<div class="summary-item">
                    								<div class="content">
                    									<h6>Type of treatment</h6>
                    									<p><span>Chosen Treatment</span></p>
                    								</div>
                    							</div>

                                                <div class="summary-list show">
                                                    <div class="summary-item show" v-for="treatment in form.treatments">
                                                        <div class="content">
                                                            <h6>{{ treatment.type }}</h6>
                                                            <p>{{ treatment.name }} <span>{{ treatment.duration }}</span></p>
                                                        </div>
                                                        <transition name="fade">
                                                            <button type="button" class="remove" @click="toggleTreatment(treatment)" v-if="page === 1">X</button>
                                                        </transition>
                                                    </div>
                                                </div>
                    						</div>
                                            <transition name="fade">
                                                <div class="summary-footer" v-if="page === 2">
                                                    <div class="confirmation">
                                                        <label><input type="checkbox" v-model="form.over16">I confirm I am above the age of 16</input></label>
                                                        <label><input type="checkbox" v-model="form.acceptTerms">I confirm I accept the <a href="#">terms & conditions</a></input></label>
                                                    </div>

                                                    <transition name="fade" mode="out-in">
                                                        <button type="button" class="book-now" @click="confirmBooking" v-if="!submitting">Confirm Booking</button>
                                                        <i class="fas fa-spinner fa-spin fa-2x" v-else></i>
                                                    </transition>

                                                    <transition name="fade">
                                                        <div class="validation-error" v-if="errors.page2" style="text-align: right;">
                                                            {{ errors.page2 }}
                                                        </div>
                                                    </transition>
                                                </div>
                                            </transition>
                    					</div>
                    					<div class="mobile-form-button">
                    					    <button type="button" class="next">Next</button>
                    					    <button type="button" class="back">Back</button>
                    					    <a href="/" class="home-button">Back Home</a>
                    					</div>
                    				</div>
        			            </div>
        			         </form>
    			        </div>
    			    </div>
    			</div>
    		</div>
		</div>
	<?php endwhile; ?>
</section>
<?php do_action( 'avada_after_content' ); ?>
<?php get_footer(); ?>
