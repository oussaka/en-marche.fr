import callApi from '../utils/api';

export const CITIZEN_PROJECTS = 'CITIZEN_PROJECTS';
export const CATEGORIES = 'CATEGORIES';
export const CITIES_AND_COUNTIES = 'CITIES_AND_COUNTIES';
export const FILTER_PROJECTS = 'FILTER_PROJECTS';

export const FILTERED_ITEM = 'FILTERED_ITEM';
export const SET_COUNTRY = 'SET_COUNTRY';
export const LOAD_MORE = 'LOAD_MORE';

const API = `${process.env.REACT_APP_API_URL}/citizen_projects`;

const options = {
    withCredentials: false,
    headers: {
        Accept: 'application/json',
    },
};

const DEFAULT_FILTER = {
  status: 'APPROVED',
  page: 1,
  page_size: 6,
}

function filterProjects(options = DEFAULT_FILTER, action) {
    let query = { ...DEFAULT_FILTER, ...options };
    query = Object.keys(query)
      .filter(key => query[key])
      .map(key => `${key}=${query[key]}`)
      .join('&');

    const path = `?${query}`;
    return {
        type: action,
        payload: callApi(API, path, {withCredentials: false, headers: {Accept: 'application/json'}}),
    };
}

export function getCitizenProjects(options) {
  return filterProjects(options, CITIZEN_PROJECTS);
}

export function loadMore(options) {
  return filterProjects(options, LOAD_MORE);
}

export function getCategories() {
    return {
        type: CATEGORIES,
        payload: callApi(API, '/categories', options),
    };
}

export function getCitiesAndCountries() {
    return {
        type: CITIES_AND_COUNTIES,
        payload: callApi(API, '/localizations', options),
    };
}

export function setFilteredItem(value) {
    return {
        type: FILTERED_ITEM,
        payload: value,
    };
}

export function setCountry(value) {
    return {
        type: SET_COUNTRY,
        payload: value,
    };
}