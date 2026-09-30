import {
    useRouter
} from 'vue-router';

export function useNavigation() {
    const router = useRouter();

    const goBack = () => router.back();
    const goHome = () => router.push('/');

    return {
        goBack,
        goHome
    };
}
