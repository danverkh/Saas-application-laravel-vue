<?php

namespace App\Models\Enums;

use ArchTech\Enums\InvokableCases;

enum ClientIndustry: string
{
    use InvokableCases;

    case BUSINESS_CONSULTANCY = 'Business Consultancy';
    case BUSINESS_RETAIL = 'Business Retail';
    case CONSUMER_GOODS_OR_SERVICES = 'Consumer Goods/Services';
    case EDUCATION = 'Education';
    case ENERGY = 'Energy';
    case EVENT_PLANNING = 'Event Planning';
    case FINANCE = 'Finance';
    case FORWARDING = 'Forwarding';
    case GAMBLING = 'Gambling';
    case HEALTH_CARE = 'Health Care';
    case HUMAN_RESOURCES = 'Human Resources';
    case INFORMATION_TECHNOLOGY = 'Information Technology';
    case INSURANCE = 'Insurance';
    case INTERIOR = 'Interior';
    case LEGAL = 'Legal';
    case MANUFACTURING = 'Manufacturing';
    case MARKETING = 'Marketing';
    case PHYSICAL_STORAGE = 'Physical Storage';
    case PRINTING = 'Printing';
    case PRIVATE_INVESTIGATION = 'Private Investigation';
    case REAL_ESTATE = 'Real Estate';
    case RECYCLING = 'Recycling';
    case TRANSLATION = 'Translation';
    case TRAVEL = 'Travel';
    case VIDEO_PRODUCTION = 'Video Production';
    case OTHER = 'OTHER';
}
