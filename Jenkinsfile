pipeline {
    agent any

    environment {
        DOCKER_IMAGE = "php-app"
        DOCKER_REGISTRY = "madnan1216/php-app-image"
        GIT_CREDENTIALS_ID = "githubcreds"
        GIT_BRANCH = "main"
        DOCKER_CREDENTIALS_ID = "dockercreds" // Add Docker credentials ID if needed
        CONTAINER_NAME = "my_app"
    }

    stages {
        stage('Checkout') {
            steps {
                script {
                    checkout([$class: 'GitSCM',
                        branches: [[name: "${GIT_BRANCH}"]],
                        userRemoteConfigs: [[url: 'https://github.com/adnnan2024/php-app-task.git', credentialsId: "${GIT_CREDENTIALS_ID}"]]
                    ])
                }
            }
        }

        stage('Build') {
            steps {
                script {
                    docker.build(DOCKER_IMAGE)
                }
            }
        }

        stage('Tag') {
            steps {
                script {
                    def tag = "${DOCKER_REGISTRY}:${env.BUILD_NUMBER}"
                    sh "docker tag ${DOCKER_IMAGE} ${tag}"
                }
            }
        }

        stage('Push') {
            steps {
                script {
                    def tag = "${DOCKER_REGISTRY}:${env.BUILD_NUMBER}"
                    withCredentials([usernamePassword(credentialsId: "${DOCKER_CREDENTIALS_ID}", usernameVariable: 'DOCKER_USERNAME', passwordVariable: 'DOCKER_PASSWORD')]) {
                        sh "echo ${DOCKER_PASSWORD} | docker login -u ${DOCKER_USERNAME} --password-stdin"
                        sh "docker push ${tag}"
                    }
                }
            }
        }

        stage('Run') {
            steps {
                script {
                    // Stop and remove any existing container
                    sh "docker stop ${CONTAINER_NAME} || true"

                    // Run the new container
                    sh "docker run --rm --netwotk php-app_app-network -d --name ${CONTAINER_NAME} -p 8082:80 ${DOCKER_REGISTRY}:${env.BUILD_NUMBER}"
                }
            }
        }

        stage('Clean Old') {
            steps {
                script {
                    // Remove old images to free up space
                    sh "docker images -q ${DOCKER_IMAGE} | xargs --no-run-if-empty docker rmi"
                }
            }
        }
    }

    post {
        always {
            cleanWs()
        }
    }
}
