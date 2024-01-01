import { computed, ref, watch, toRefs } from "vue";

export default function useWeather(now, fiveDay) {
    const nowRefs = toRefs(now);
    const infoNow = computed(() => nowRefs.main.value);
    const iconNow = computed(
        () =>
            `https://openweathermap.org/img/wn/${nowRefs.weather.value[0].icon}@2x.png`,
    );
    const descNow = computed(() =>
        nowRefs.weather.value[0].description.toUpperCase(),
    );

    const fiveDays = computed(() => {
        const uniqueDates = new Set();
        return fiveDay
            .filter((day) => {
                const date = new Date(day.dt_txt).toLocaleDateString("en-US", {
                    month: "short",
                    day: "numeric",
                });
                if (!uniqueDates.has(date)) {
                    uniqueDates.add(date);
                    return true;
                }
                return false;
            })
            .slice(1);
    });

    const dtToShort = (dt) =>
        new Date(dt).toLocaleDateString("en-US", {
            weekday: "short",
            month: "short",
            day: "numeric",
        });

    const dt2LocalT = () => {
        const offsetSeconds = now.timezone;
        let nowUtc = Date.now() + new Date().getTimezoneOffset() * 60000;
        let date = new Date(nowUtc + offsetSeconds * 1000);
        return date.toLocaleTimeString(undefined, {
            hour: "2-digit",
            minute: "2-digit",
            hour12: true,
        });
    };

    const toFahrenheit = (Ctemp) => ((Ctemp * 9) / 5 + 32).toFixed(0);

    const showInF = ref(false);
    const shownTemp = (temp) =>
        showInF.value ? `${toFahrenheit(temp)}°F` : `${temp}°C`;

    const timeNow = ref(dt2LocalT());

    watch(showInF, shownTemp);

    return {
        infoNow,
        iconNow,
        descNow,
        fiveDays,
        dtToShort,
        dt2LocalT,
        toFahrenheit,
        showInF,
        shownTemp,
        timeNow,
    };
}
