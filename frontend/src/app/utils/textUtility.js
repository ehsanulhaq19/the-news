export const replaceString = (string, replaceTo, replaceWith = "{value}") => {
    return string.replace(replaceWith, replaceTo)
}