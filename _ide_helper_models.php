<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\BillingAddress
 *
 * @property int $id
 * @property int $user_id
 * @property int $country_id
 * @property string|null $company_name
 * @property string $street
 * @property string $postal_code
 * @property string $city
 * @property string|null $vat_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Country $country
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress whereVatNumber($value)
 * @mixin \Eloquent
 */
	class IdeHelperBillingAddress {}
}

namespace App\Models{
/**
 * App\Models\Client
 *
 * @property int $id
 * @property string $name
 * @property string $legal_person
 * @property string $owner
 * @property int|null $bank_details_id
 * @property string|null $vatin
 * @property string|null $street
 * @property string|null $zip
 * @property string|null $city
 * @property string|null $country
 * @property string|null $extra_info
 * @property string $accounting_email
 * @property string $industry
 * @property string $source
 * @property int|null $payment_due_days
 * @property string $payment_method
 * @property string|null $stripe_customer_id
 * @property string|null $stripe_payment_method_id
 * @property int|null $termination_notice_period_in_days
 * @property string $creation_date
 * @property int $employee_id
 * @property string|null $deletion_date
 * @property string $send_info_emails
 * @property string|null $last_info_email_sent_date
 * @property string|null $retention_email_1_sent
 * @property string|null $retention_email_2_sent
 * @property string|null $retention_email_3_sent
 * @property string|null $retention_email_4_sent
 * @property float|null $not_canceled_mrr
 * @property string|null $autoranker_bonus_email_1_sent
 * @property string $accountmanager_introduction_sent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ClientAccount> $accounts
 * @property-read int|null $accounts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @method static \Illuminate\Database\Eloquent\Builder|Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client query()
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereAccountingEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereAccountmanagerIntroductionSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereAutorankerBonusEmail1Sent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereBankDetailsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCreationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereDeletionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereExtraInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereIndustry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereLastInfoEmailSentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereLegalPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereNotCanceledMrr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereOwner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client wherePaymentDueDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereRetentionEmail1Sent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereRetentionEmail2Sent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereRetentionEmail3Sent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereRetentionEmail4Sent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereSendInfoEmails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereStripeCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereStripePaymentMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereTerminationNoticePeriodInDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereVatin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereZip($value)
 * @mixin \Eloquent
 */
	class IdeHelperClient {}
}

namespace App\Models{
/**
 * App\Models\ClientAccount
 *
 * @property int $id
 * @property int $client_id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $gender
 * @property string $email
 * @property string $language
 * @property string $contact_style
 * @property string|null $password
 * @property string $creation_date
 * @property string|null $deletion_date
 * @property-read \App\Models\Client $client
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAccount whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAccount whereContactStyle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAccount whereCreationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAccount whereDeletionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAccount whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAccount whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAccount whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAccount whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAccount whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAccount wherePassword($value)
 * @mixin \Eloquent
 */
	class IdeHelperClientAccount {}
}

namespace App\Models{
/**
 * App\Models\Country
 *
 * @property int $id
 * @property string $name
 * @property string $iso2
 * @property string $iso3
 * @property string $tld
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Language> $languages
 * @property-read int|null $languages_count
 * @method static \Illuminate\Database\Eloquent\Builder|Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country query()
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereIso2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereIso3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereTld($value)
 * @mixin \Eloquent
 */
	class IdeHelperCountry {}
}

namespace App\Models{
/**
 * App\Models\Keyword
 *
 * @property int $id
 * @property int $order_id
 * @property string $keyword
 * @property string|null $domain
 * @property string|null $path_to_ranking_subpage
 * @property string $country
 * @property string $monthly_fee
 * @property string $setup_fee
 * @property int|null $search_volume
 * @property string $maximum_cost
 * @property string $creation_date
 * @property string|null $start_date
 * @property string|null $termination_date
 * @property string $termination_confirmed
 * @property string $termination_executed
 * @property int|null $termination_reason_id
 * @property string|null $termination_recorded_date
 * @property string $setup_fee_invoiced
 * @property string|null $order_fulfillment_request_date
 * @property int|null $order_fulfillment_employee_id
 * @property int|null $autoranker_experiment_id
 * @property string|null $recurring_month_invoiced
 * @property string|null $top_ten_notification_sent
 * @property string|null $top_five_notification_sent
 * @property int|null $last_rank_reported
 * @property int|null $last_website_ranking
 * @property string|null $last_website_ranking_update_date
 * @property string|null $ranking_subpage_content
 * @property string|null $ranking_subpage_content_last_fetched
 * @property-read \App\Models\Order $order
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword query()
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereAutorankerExperimentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereCreationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereKeyword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereLastRankReported($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereLastWebsiteRanking($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereLastWebsiteRankingUpdateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereMaximumCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereMonthlyFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereOrderFulfillmentEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereOrderFulfillmentRequestDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword wherePathToRankingSubpage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereRankingSubpageContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereRankingSubpageContentLastFetched($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereRecurringMonthInvoiced($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereSearchVolume($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereSetupFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereSetupFeeInvoiced($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereTerminationConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereTerminationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereTerminationExecuted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereTerminationReasonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereTerminationRecordedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereTopFiveNotificationSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereTopTenNotificationSent($value)
 * @mixin \Eloquent
 */
	class IdeHelperKeyword {}
}

namespace App\Models{
/**
 * App\Models\Language
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Country> $countries
 * @property-read int|null $countries_count
 * @method static \Illuminate\Database\Eloquent\Builder|Language newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Language newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Language query()
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereName($value)
 * @mixin \Eloquent
 */
	class IdeHelperLanguage {}
}

namespace App\Models{
/**
 * App\Models\Order
 *
 * @property int $id
 * @property string $name
 * @property int $client_id
 * @property int $employee_id
 * @property string|null $contact_first_name
 * @property string|null $contact_last_name
 * @property string|null $contact_gender
 * @property string $contact_email
 * @property string $contact_language
 * @property string $contact_style
 * @property string $first_upsell_email_sent
 * @property string $second_upsell_email_sent
 * @property string $creation_date
 * @property string $client_account_created
 * @property string $order_confirmation_sent
 * @property-read \App\Models\Client $client
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Keyword> $keywords
 * @property-read int|null $keywords_count
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereClientAccountCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereContactEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereContactFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereContactGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereContactLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereContactLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereContactStyle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereFirstUpsellEmailSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderConfirmationSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereSecondUpsellEmailSent($value)
 * @mixin \Eloquent
 */
	class IdeHelperOrder {}
}

namespace App\Models{
/**
 * App\Models\SuccessStory
 *
 * @property int $id
 * @property int $client_id
 * @property string $client_industry
 * @property string $client_country
 * @property string $client_city
 * @property string $monthly_fee
 * @property array $keywords
 * @property array $chart
 * @property \Illuminate\Support\Carbon $campaign_active_since
 * @property string $ctr
 * @property \Illuminate\Support\Carbon $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|SuccessStory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuccessStory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuccessStory query()
 * @method static \Illuminate\Database\Eloquent\Builder|SuccessStory whereCampaignActiveSince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuccessStory whereChart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuccessStory whereClientCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuccessStory whereClientCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuccessStory whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuccessStory whereClientIndustry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuccessStory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuccessStory whereCtr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuccessStory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuccessStory whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuccessStory whereMonthlyFee($value)
 * @mixin \Eloquent
 */
	class IdeHelperSuccessStory {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $login_hash
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\BillingAddress|null $billingAddress
 * @property-read \App\Models\ClientAccount|null $clientAccount
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLoginHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperUser {}
}

