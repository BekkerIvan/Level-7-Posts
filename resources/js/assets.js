export function getAPIPath (includeCurrentPath = false) {
    const origin = window.location.origin;
    if (!includeCurrentPath) {
        return origin+"/api";
    }
    const pathName = window.location.pathname;
    return origin+"/api"+pathName;
}
