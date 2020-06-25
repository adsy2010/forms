//vue js router urls
export const CLAIMS_FOLDER = './components/claim/';
export const MILEAGE_CLAIMS_FOLDER = CLAIMS_FOLDER + 'mileage';
export const TIME_CLAIMS_FOLDER = CLAIMS_FOLDER + 'time';

//helper partial URLs
export const USER_ROOT_URL = '/user/';
export const CLAIMS_ROOT_URL = '/claims/';
export const ADMIN_ROOT_URL ='/!/admin/';


//laravel api urls
export const SITE_BASE_URL = 'http://localhost:8080';
export const API_BASE_URL = SITE_BASE_URL + '/api/v2';

//SITE URLS
export const USER_URL = API_BASE_URL + USER_ROOT_URL;
export const MY_TEAM_URL = API_BASE_URL + USER_ROOT_URL + 'team/';
export const MESSAGES_URL = API_BASE_URL + USER_ROOT_URL + 'messages/';
export const MY_TRAVEL_CLAIMS_URL = API_BASE_URL + CLAIMS_ROOT_URL + 'travel/';
export const MY_TIME_CLAIMS_URL = API_BASE_URL + CLAIMS_ROOT_URL + 'time/';

//ADMIN URLS
export const ADMIN_URL = API_BASE_URL + ADMIN_ROOT_URL;
export const ADMIN_USERS_URL = ADMIN_URL + 'users/';
export const ADMIN_GROUPS_URL = ADMIN_URL + 'groups/';
export const ADMIN_SESSIONS_URL = ADMIN_URL + 'sessions/';
